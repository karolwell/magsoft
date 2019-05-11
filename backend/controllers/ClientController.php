<?php

namespace backend\controllers;

use Yii;
use backend\models\Client;
use backend\models\SortieStock;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
    if (in_array($action->id, ['ajouter_client','activer_desactiver','details','supprimer'])) {
        $this->enableCsrfValidation = false;
    }
    return parent::beforeAction($action);
}


    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
       /* $searchModel = new MenuSearch();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);*/
       $client = new Client();
       $clients = $client->find()->where('statut<>0')->all();

       return $this->render('index', [
        'clients' => $clients,
        'client' => $client,
    ]);
   }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetails()
    {
        $sortieStock = new SortieStock();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['client'];
            $sortieStocks = SortieStock::find()->where(['id_client'=>(int)$id])->andWhere('statut<>0')->all();

            $this->layout = false;
            return $this->render('view', [
                'sortieStocks' => $sortieStocks,
            ]);
        }

    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAjouter_client()
    {
        $client = new Client();
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post()['client'];
            if($params['id']!=0){
                $client = Client::find()->where(['id'=>(int)$params['id']])->one();
            } //exit;
            if(!empty($params['nom'])){
                foreach ($client as $key => $value) {

                    if(isset($params[$key])){
                        $client->$key=$params[$key];
                    }

                }


                if($client->id){
                    $client->date_update = date('Y-m-d H:i:s');
                    $client->update_by = Yii::$app->user->identity->id;
                    if($client->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Client modifié avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec de modification du client',
                        //'results'=>$client->getErrors(),
                        ] ;
                    }

                }else{
                    $exist = Client::find()->where(['nom'=>$client->nom])->one();
                    if($exist && $exist->statut==0){
                        $exist->statut = 1;
                        $exist->date_create = date('Y-m-d H:i:s');
                        $exist->create_by = Yii::$app->user->identity->id;
                        if($exist->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'Client enrégistré avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement du client',
                            //'results'=>$client->getErrors(),
                            ] ;
                        }
                    }else{
                       $client->date_create = date('Y-m-d H:i:s');
                       $client->create_by = Yii::$app->user->identity->id;
                       if($client->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Client enrégistré avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec d\'enrégistrement du client',
                            //'results'=>$client->getErrors(),
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
        $client = new Client();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $operation = Yii::$app->request->post()['operation'];
            $client = client::find()->where(['id'=>(int)$id])->one();
            if($operation == 2){

                $client->statut = 1;
                $msg = 'menu activé avec succès';

            }elseif($operation == 1){

                $client->statut = 2;
                $msg = 'menu désactivé avec succès';
            }

            if($client->save()){
                $data = [
                    'state' => 'ok',
                    'message' => $msg,
                ];
            }else{
             $data = [
                'state' => 'ko',
                'message' => 'Echec de l\'opération sur ce client',
                //'error' => $client->getErrors(),
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
        $client = new Client();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $client = Client::find()->where(['id'=>(int)$id])->one();

            $client->statut = 0;

            if($client->save()){
                $data = [
                    'state' => 'ok',
                    'message' => 'Client supprimer avec succès',
                ];
            }else{
               $data = [
                'state' => 'ko',
                'message' => 'Echec de suppression de client',
                'error' => $client->getErrors(),
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
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
