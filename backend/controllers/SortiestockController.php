<?php

namespace backend\controllers;

use Yii;
use backend\models\SortieStock;
use backend\models\Produit;
use backend\models\Client;
use backend\models\Categorie;
use backend\models\Fiche;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SortiestockController implements the CRUD actions for SortieStock model.
 */
class SortiestockController extends Controller
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
    if (in_array($action->id, ['sortie_stock','activer_desactiver','details','supprimer'])) {
        $this->enableCsrfValidation = false;
    }
    return parent::beforeAction($action);
}


    /**
     * Lists all SortieStock models.
     * @return mixed
     */
    public function actionIndex()
    {
     $sortieStock = new SortieStock();
     $sortieStocks = SortieStock::find()->where('statut<>0')->groupby('reference')->all();;
     $categories = Categorie::find()->where('statut<>0')->all();
     $clients = Client::find()->where('statut<>0')->all();

     return $this->render('index', [
        'sortieStocks' =>$sortieStocks,
        'sortieStock' =>$sortieStock,
        'categories' => $categories,
        'clients' => $clients,
    ]);
 }

    /**
     * Displays a single SortieStock model.
     * @param integer $reference
     * @return mixed
     */
    public function actionDetails()
    {
        $sortieStock = new SortieStock();
        if(Yii::$app->request->isAjax){
            $ref = Yii::$app->request->post()['reference'];
            $sortieStocks = sortieStock::find()->where(['reference'=>$ref])->andWhere('statut<>0')->all();

            $this->layout = false;
            return $this->render('view', [
                'sortieStocks' => $sortieStocks,
            ]);
        }

    }

    /**
     * Creates a new SortieStock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSortie_stock()
    {
        $fiche = new Fiche();
        if(Yii::$app->request->isPost){
            $infos = Yii::$app->request->post();
            $produits = $infos['id_produits'];
            $clients = $infos['id_clients'];
            $quantites = $infos['quantites'];
            $reference = Yii::$app->security->generateRandomString(32); 
            //print_r($infos);exit;
            foreach ($produits as $key => $produit) {

               $sortieStock = new SortieStock();
               $sortieStock->reference = $reference;
               $sortieStock->id_produit = $produits[$key];
               $sortieStock->quantite = $quantites[$key];
               $sortieStock->id_client = $clients[$key];
               $sortieStock->date_create = date('Y-m-d H:i:s');
               $sortieStock->create_by = Yii::$app->user->identity->id;
               $produit = Produit::find()->where(['id'=>$sortieStock->id_produit])->one();
               $produit->quantite -= $sortieStock->quantite;
               $produit->save();
               $sortieStock->save();
               //if($entreeStock->save()){}else{print_r($entreeStock->getErrors());}
               /*print_r($produits[$key]);
               print_r('-');
               print_r($quantites[$key]);
               print_r('-');
               print_r($fournisseurs[$key]);
               print_r('*');*/
            }
            //exit;
            //$fiche->file = UploadedFile::getInstance($fiche, 'file');
            //$fiche->file->saveAs(Yii::$app->homeUrl.'web/fiches/' . $fiche->file->baseName . '.' . $fiche->file->extension);
            //print_r($infos);exit;
            $this->redirect(['sortiestock/index']);
        }
    }

    /**
     * Creates a new SortieStock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSortie_stock_()
    {
       $sortieStock = new SortieStock();
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post()['produit'];
            if($params['id']!=0){
               $sortieStock = SortieStock::find()->where(['id'=>(int)$params['id']])->one();
            } 
            //exit;
            if(!empty($params['designation'])){
                foreach ($sortieStock as $key => $value) {

                    if(isset($params[$key])){
                       $sortieStock->$key=$params[$key];
                    }

                }


                if($sortieStock->id){
                   $sortieStock->date_update = date('Y-m-d H:i:s');
                   $sortieStock->update_by = Yii::$app->user->identity->id;
                    if($sortieStock->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Vente modifié avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec de modification de la vente',
                        //'results'=>$menu->getErrors(),
                        ] ;
                    }

                }else{
                    $exist = SortieStock::find()->where(['reference'=>$sortieStock->reference,'id_produit'=>$sortieStock->id_produit])->one();
                    if($exist && $exist->statut==0){
                        $exist->statut = 1;
                       $sortieStock->date_update = date('Y-m-d H:i:s');
                       $sortieStock->update_by = Yii::$app->user->identity->id;
                        if($exist->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'Vente enrégistré avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement de la vente',
                            //'results'=>$menu->getErrors(),
                            ] ;
                        }
                    }else{
                       $sortieStock->date_create = date('Y-m-d H:i:s');
                       $sortieStock->create_by = Yii::$app->user->identity->id;
                        if($sortieStock->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'Vente enrégistrée avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement de la vente',
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
       $sortieStock = new $sortieStock();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $operation = Yii::$app->request->post()['operation'];
           $sortieStock = SortieStock::find()->where(['id'=>(int)$id])->one();
            if($operation == 2){

               $sortieStock->statut = 1;
                $msg = 'Vente activée avec succès';

            }elseif($operation == 1){

               $sortieStock->statut = 2;
                $msg = 'Vente désactivé avec succès';
            }

            if($sortieStock->save()){
                $data = [
                    'state' => 'ok',
                    'message' => $msg,
                ];
            }else{
               $data = [
                'state' => 'ko',
                'message' => 'Echec de l\'opération sur cette vente',
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
       $sortieStock = new $sortieStock();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
           $sortieStock = SortieStock::find()->where(['id'=>(int)$id])->one();

           $sortieStock->statut = 0;

            if($sortieStock->save()){
                $data = [
                    'state' => 'ok',
                    'message' => 'Vente supprimée avec succès',
                ];
            }else{
             $data = [
                'state' => 'ko',
                'message' => 'Echec de suppression de la vente',
                'error' =>$sortieStock->getErrors(),
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
        if (($model = SortieStock::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
