<?php

namespace backend\controllers;

use Yii;
use backend\controllers\Common;
use backend\models\Menu;
use backend\models\SousMenu;
use backend\models\MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['ajouter_menu','activer_desactiver','supprimer'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
       /* $searchModel = new MenuSearch();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);*/
       $menu = new Menu();
       $menus = $menu->find()->where('statut<>0')->all();

       $allActions = Common::getAllcontrolleractions();

       return $this->render('index', [
        'menus' => $menus,
        'menu' => $menu,
        'allActions' => $allActions,
    ]);
   }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAjouter_menu()
    {
        $menu = new Menu();
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post()['menu'];
            if($params['id']!=0){
                $menu = Menu::find()->where(['id'=>(int)$params['id']])->one();
            } //exit;
            if(!empty($params['libelle'])){
                foreach ($menu as $key => $value) {

                    if(isset($params[$key])){
                        $menu->$key=$params[$key];
                    }

                }


                if($menu->id){

                    if($menu->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Menu modifié avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec de modification du menu',
                        //'results'=>$menu->getErrors(),
                        ] ;
                    }

                }else{
                    $exist = Menu::find()->where(['libelle'=>$menu->libelle])->one();
                    if($exist && $exist->statut==0){
                        $exist->statut = 1;
                        if($exist->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'Menu enrégistré avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement du menu',
                            //'results'=>$menu->getErrors(),
                            ] ;
                        }
                    }else{

                     if($menu->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'menu enrégistré avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec d\'enrégistrement du menu',
                            //'results'=>$menu->getErrors(),
                        ] ;
                    }

                }

            }

        }else{
            $data = [
                'state'=>'ko',
                'message'=>'Veuillez renseigner le formulaire s\'il vous plait',
            ] ;
        }

        $class = $data['state']=='ok'? 'success':'error';
        $message = $data['message'];

        Yii::$app->getSession()->setFlash($class,$message);

        return json_encode($data);

    }

    }


    /**
     * Deletes an existing menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
     public function actionActiver_desactiver()
     {
            $menu = new Menu();
            if(Yii::$app->request->isAjax){
                $id = Yii::$app->request->post()['id'];
                $operation = Yii::$app->request->post()['operation'];
                $menu = Menu::find()->where(['id'=>(int)$id])->one();
                if($operation == 2){

                    $menu->statut = 1;
                    $msg = 'menu activé avec succès';

                }elseif($operation == 1){

                    $menu->statut = 2;
                    $msg = 'menu désactivé avec succès';
                }

                if($menu->save()){
                    $data = [
                        'state' => 'ok',
                        'message' => $msg,
                    ];
                }else{
                   $data = [
                    'state' => 'ko',
                    'message' => 'Echec de l\'opération sur ce menu',
                //'error' => $menu->getErrors(),
                ];
            }
            $class = $data['state']=='ok'? 'success':'error';
            $message = $data['message'];

            Yii::$app->getSession()->setFlash($class,$message);

            return json_encode($data);
     } 
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSupprimer()
    {
        $profile = new Profile();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $profile = Profile::find()->where(['id'=>(int)$id])->one();

            $profile->statut = 0;

            if($profile->save()){
                $data = [
                    'state' => 'ok',
                    'message' => 'Profile supprimer avec succès',
                ];
            }else{
             $data = [
                'state' => 'ko',
                'message' => 'Echec de suppression de profile',
                'error' => $profile->getErrors(),
            ];
        }
        $class = $data['state']=='ok'? 'success':'error';
        $message = $data['message'];

        Yii::$app->getSession()->setFlash($class,$message);

        return json_encode($data);
    } 
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
