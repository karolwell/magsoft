<?php

namespace backend\controllers;

use Yii;
use backend\controllers\Common;
use backend\models\Menu;
use backend\models\SousMenu;
use backend\models\SousMenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SousMenuController implements the CRUD actions for SousMenu model.
 */
class SousmenuController extends Controller
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
        if (in_array($action->id, ['ajouter_sousmenu','details','activer_desactiver','supprimer','visibiliter'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    

    /**
     * Lists all SousMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new SousMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);*/

        $sousmenu = new SousMenu();
        $sousmenus = $sousmenu->find()->where('statut<>0')->all();
        $menus = Menu::find()->where('statut<>0')->orderby('position DESC')->all();

        $allActions = Common::getAllcontrolleractions();

        return $this->render('index', [
            'menus' => $menus,
            'sousmenus' => $sousmenus,
            'sousmenu' => $sousmenu,
            'allActions' => $allActions,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetails()
    {
        $sousmenu = new SousMenu();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['sousmenu'];
            $sousmenu = SousMenu::find()->where(['id'=>(int)$id])->one();

            $this->layout = false;
            return $this->render('view', [
                'sousmenu' => $sousmenu,
            ]);
        }

    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAjouter_sousmenu()
    {
        $sousmenu = new SousMenu();
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post()['sousmenu'];
            if($params['id']!=0){
                $sousmenu = SousMenu::find()->where(['id'=>(int)$params['id']])->one();
            } //exit;
            if(!empty($params['libelle'])){
                foreach ($sousmenu as $key => $value) {

                    if(isset($params[$key])){
                        $sousmenu->$key=$params[$key];
                    }

                }


                if($sousmenu->id){

                    if($sousmenu->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Sous menu modifié avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec de modification du sous menu',
                        //'results'=>$sousmenu->getErrors(),
                        ] ;
                    }

                }else{
                    $exist = SousMenu::find()->where(['libelle'=>$sousmenu->libelle,'menuId'=>$sousmenu->menuId])->one();
                    if($exist && $exist->statut==0){
                        $exist->statut = 1;
                        if($exist->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'Sous menu enrégistré avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement du sous menu',
                            //'results'=>$sousmenu->getErrors(),
                            ] ;
                        }
                    }else{
                    //print_r($sousmenu);exit;

                     if($sousmenu->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Sous menu enrégistré avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec d\'enrégistrement du sous menu',
                            //'results'=>$sousmenu->getErrors(),
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
            $sousmenu = new SousMenu();
            if(Yii::$app->request->isAjax){
                $id = Yii::$app->request->post()['id'];
                $operation = Yii::$app->request->post()['operation'];
                $sousmenu = SousMenu::find()->where(['id'=>(int)$id])->one();
                if($operation == 2){

                    $sousmenu->statut = 1;
                    $msg = 'Sous menu activé avec succès';

                }elseif($operation == 1){

                    $sousmenu->statut = 2;
                    $msg = 'Sous menu désactivé avec succès';
                }

                if($sousmenu->save()){
                    $data = [
                        'state' => 'ok',
                        'message' => $msg,
                    ];
                }else{
                   $data = [
                    'state' => 'ko',
                    'message' => 'Echec de l\'opération sur ce sous menu',
                //'error' => $sousmenu->getErrors(),
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
        $sousmenu = new SousMenu();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $sousmenu = SousMenu::find()->where(['id'=>(int)$id])->one();

            $sousmenu->statut = 0;

            if($sousmenu->save()){
                $data = [
                    'state' => 'ok',
                    'message' => 'Sous menu supprimer avec succès',
                ];
            }else{
             $data = [
                'state' => 'ko',
                'message' => 'Echec de suppression du sous menu',
                //'error' => $sousmenu->getErrors(),
            ];
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
     public function actionVisibiliter()
     {
            $sousmenu = new SousMenu();
            if(Yii::$app->request->isAjax){
                $id = Yii::$app->request->post()['id'];
                $operation = Yii::$app->request->post()['operation'];
                $sousmenu = SousMenu::find()->where(['id'=>(int)$id])->one();
                if($operation == 0){

                    $sousmenu->visible = 1;
                    $msg = 'Sous menu rendu visible avec succès';

                }elseif($operation == 1){

                    $sousmenu->visible = 0;
                    $msg = 'Sous menu rendu invisible avec succès';
                }

                if($sousmenu->save()){
                    $data = [
                        'state' => 'ok',
                        'message' => $msg,
                    ];
                }else{
                   $data = [
                    'state' => 'ko',
                    'message' => 'Echec de l\'opération sur ce sous menu',
                //'error' => $sousmenu->getErrors(),
                ];
            }
            $class = $data['state']=='ok'? 'success':'error';
            $message = $data['message'];

            Yii::$app->getSession()->setFlash($class,$message);

            return json_encode($data);
     } 
     }


    /**
     * Finds the SousMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SousMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SousSousMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
