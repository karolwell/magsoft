<?php

namespace backend\controllers;

use Yii;
use backend\models\Fournisseur;
use backend\models\EntreeStock;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FournisseurController implements the CRUD actions for Fournisseur model.
 */
class FournisseurController extends Controller
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
        if (in_array($action->id, ['ajouter_fournisseur','activer_desactiver','details','supprimer'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    /**
     * Lists all Fournisseur models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->request->isAjax){
            $this->layout = false;
        }
       $fournisseur = new Fournisseur();
       $fournisseurs = $fournisseur->find()->where('statut<>0')->all();

       return $this->render('index', [
        'fournisseurs' => $fournisseurs,
        'fournisseur' => $fournisseur,
    ]);
   }

    /**
     * Displays a single Fournisseur model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetails()
    {
        $entreeStock = new EntreeStock();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['fournisseur'];
            $entreeStocks = EntreeStock::find()->where(['id_fournisseur'=>(int)$id])->andWhere('statut<>0')->all();

            $this->layout = false;
            return $this->render('view', [
                'entreeStocks' => $entreeStocks,
            ]);
        }

    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAjouter_fournisseur()
    {
        $this->layout = false;
        $fournisseur = new Fournisseur();
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post()['fournisseur'];
            if($params['id']!=0){
                $fournisseur = Fournisseur::find()->where(['id'=>(int)$params['id']])->one();
            } //exit;
            if(!empty($params['nom'])){
                foreach ($fournisseur as $key => $value) {

                    if(isset($params[$key])){
                        $fournisseur->$key=$params[$key];
                    }

                }


                if($fournisseur->id){
                    $fournisseur->date_update = date('Y-m-d H:i:s');
                    $fournisseur->update_by = Yii::$app->user->identity->id;
                    if($fournisseur->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Fournisseur modifié avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec de modification du fournisseur',
                        //'results'=>$fournisseur->getErrors(),
                        ] ;
                    }

                }else{
                    $exist = Fournisseur::find()->where(['nom'=>$fournisseur->nom])->one();
                    if($exist && $exist->statut==0){
                        $exist->statut = 1;
                        $exist->date_create = date('Y-m-d H:i:s');
                        $exist->create_by = Yii::$app->user->identity->id;
                        if($exist->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'Fournisseur enrégistré avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement du fournisseur',
                            //'results'=>$fournisseur->getErrors(),
                            ] ;
                        }
                    }else{
                     $fournisseur->date_create = date('Y-m-d H:i:s');
                     $fournisseur->create_by = Yii::$app->user->identity->id;
                     if($fournisseur->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Fournisseur enrégistré avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec d\'enrégistrement du fournisseur',
                            //'results'=>$fournisseur->getErrors(),
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
     * Deletes an existing client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActiver_desactiver()
    {
        $fournisseur = new Fournisseur();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $operation = Yii::$app->request->post()['operation'];
            $fournisseur = Fournisseur::find()->where(['id'=>(int)$id])->one();
            if($operation == 2){

                $fournisseur->statut = 1;
                $msg = 'menu activé avec succès';

            }elseif($operation == 1){

                $fournisseur->statut = 2;
                $msg = 'menu désactivé avec succès';
            }

            if($fournisseur->save()){
                $data = [
                    'state' => 'ok',
                    'message' => $msg,
                ];
            }else{
               $data = [
                'state' => 'ko',
                'message' => 'Echec de l\'opération sur ce fournisseur',
                //'error' => $fournisseur->getErrors(),
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
        $fournisseur = new Fournisseur();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $fournisseur = Fournisseur::find()->where(['id'=>(int)$id])->one();

            $fournisseur->statut = 0;

            if($fournisseur->save()){
                $data = [
                    'state' => 'ok',
                    'message' => 'Fournisseur supprimer avec succès',
                ];
            }else{
             $data = [
                'state' => 'ko',
                'message' => 'Echec de suppression du fournisseur',
                'error' => $fournisseur->getErrors(),
            ];
        }
        $class = $data['state']=='ok'? 'success':'error';
        $message = $data['message'];

        Yii::$app->getSession()->setFlash($class,$message);

        return json_encode($data);
    } 
}

    /**
     * Finds the client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fournisseur::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
