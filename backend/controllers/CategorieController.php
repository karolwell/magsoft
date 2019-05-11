<?php

namespace backend\controllers;

use Yii;
use backend\models\Categorie;
use backend\models\Produit;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategorieController implements the CRUD actions for Categorie model.
 */
class CategorieController extends Controller
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
        if (in_array($action->id, ['ajouter_categorie','activer_desactiver','produits','supprimer'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    

    /**
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
       $categorie = new Categorie();
       $categories = $categorie->find()->where('statut<>0')->all();

       return $this->render('index', [
        'categories' => $categories,
        'categorie' => $categorie,
    ]);
   }

    /**
     * Displays a single Categorie model.
     * @param integer $id
     * @return mixed
     */
    public function actionProduits()
    {
        $produit = new Produit();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['categorie'];
            $produits = Produit::find()->where(['id_categorie'=>(int)$id])->andWhere('statut<>0')->all();

            $this->layout = false;
            return $this->render('view', [
                'produits' => $produits,
            ]);
        }

    }

    /**
     * Creates a new Categorie model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAjouter_categorie()
    {
        $categorie = new Categorie();
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post()['categorie'];
            if($params['id']!=0){
                $categorie = Categorie::find()->where(['id'=>(int)$params['id']])->one();
            } 
            //exit;
            if(!empty($params['designation'])){
                foreach ($categorie as $key => $value) {

                    if(isset($params[$key])){
                        $categorie->$key=$params[$key];
                    }

                }


                if($categorie->id){
                    $categorie->date_update = date('Y-m-d H:i:s');
                    $categorie->update_by = Yii::$app->user->identity->id;
                    if($categorie->save()){
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
                    $exist = Categorie::find()->where(['designation'=>$categorie->designation])->one();
                    if($exist && $exist->statut==0){
                        $exist->statut = 1;
                        $categorie->date_update = date('Y-m-d H:i:s');
                        $categorie->update_by = Yii::$app->user->identity->id;
                        if($exist->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'Catégorie enrégistré avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement de la Catégorie',
                            //'results'=>$menu->getErrors(),
                            ] ;
                        }
                    }else{
                        $categorie->date_create = date('Y-m-d H:i:s');
                        $categorie->create_by = Yii::$app->user->identity->id;
                       if($categorie->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Catégorie enrégistré avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec d\'enrégistrement de la Catégorie',
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
     * Deletes an existing Categorie model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActiver_desactiver()
    {
        $categorie = new Categorie();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $operation = Yii::$app->request->post()['operation'];
            $categorie = Categorie::find()->where(['id'=>(int)$id])->one();
            if($operation == 2){

                $categorie->statut = 1;
                $msg = 'Catégorie activé avec succès';

            }elseif($operation == 1){

                $categorie->statut = 2;
                $msg = 'Catégorie désactivé avec succès';
            }

            if($categorie->save()){
                $data = [
                    'state' => 'ok',
                    'message' => $msg,
                ];
            }else{
             $data = [
                'state' => 'ko',
                'message' => 'Echec de l\'opération sur cette Catégorie',
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
     * Deletes an existing Categorie model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSupprimer()
    {
        $categorie = new Categorie();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $categorie = Categorie::find()->where(['id'=>(int)$id])->one();

            $categorie->statut = 0;

            if($categorie->save()){
                $data = [
                    'state' => 'ok',
                    'message' => 'Catégorie supprimer avec succès',
                ];
            }else{
               $data = [
                'state' => 'ko',
                'message' => 'Echec de suppression de cette Catégorie',
                'error' => $categorie->getErrors(),
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
        if (($model = Categorie::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
