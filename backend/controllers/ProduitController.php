<?php

namespace backend\controllers;

use Yii;
use backend\models\Categorie;
use backend\models\Produit;
use backend\models\EntreeStock;
use backend\models\SortieStock;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProduitController implements the CRUD actions for Produit model.
 */
class ProduitController extends Controller
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
        if (in_array($action->id, ['ajouter_produit','activer_desactiver','mouvement','supprimer'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    

    /**
     * Lists all Produit models.
     * @return mixed
     */
    public function actionIndex()
    {
     $produit = new Produit();
     $produits = $produit->find()->where('statut<>0')->all();
     $categories = Categorie::find()->where('statut<>0')->all();

     return $this->render('index', [
        'categories' => $categories,
        'produits' => $produits,
        'produit' => $produit,
    ]);
 }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionMouvements()
    {
        $produit = new Produit();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['produit'];
            $entreeStrocks = EntreeStock::find()->where(['id_produit'=>(int)$id])->andWhere('statut<>0')->all();
            $sortieStrocks = SortieStock::find()->where(['id_produit'=>(int)$id])->andWhere('statut<>0')->all();

            $this->layout = false;
            return $this->render('view', [
                'entreeStrocks' => $entreeStrocks,
                'sortieStrocks' => $sortieStrocks,
            ]);
        }

    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAjouter_produit()
    {
        $produit = new Produit();
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post()['produit'];
            if($params['id']!=0){
                $produit = Produit::find()->where(['id'=>(int)$params['id']])->one();
            } 
            //exit;
            if(!empty($params['designation'])){
                foreach ($produit as $key => $value) {

                    if(isset($params[$key])){
                        $produit->$key=$params[$key];
                    }

                }


                if($produit->id){
                    $produit->date_update = date('Y-m-d H:i:s');
                    $produit->update_by = Yii::$app->user->identity->id;
                    if($produit->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Produit modifié avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec de modification du produit',
                        //'results'=>$menu->getErrors(),
                        ] ;
                    }

                }else{
                    $exist = Produit::find()->where(['designation'=>$produit->designation])->one();
                    if($exist && $exist->statut==0){
                        $exist->statut = 1;
                        $produit->date_update = date('Y-m-d H:i:s');
                        $produit->update_by = Yii::$app->user->identity->id;
                        if($exist->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'Produit enrégistré avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement du produit',
                            //'results'=>$menu->getErrors(),
                            ] ;
                        }
                    }else{
                        $produit->date_create = date('Y-m-d H:i:s');
                        $produit->create_by = Yii::$app->user->identity->id;
                        if($produit->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'Produit enrégistré avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement du produit',
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
        $produit = new Produit();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $operation = Yii::$app->request->post()['operation'];
            $produit = Produit::find()->where(['id'=>(int)$id])->one();
            if($operation == 2){

                $produit->statut = 1;
                $msg = 'Produit activé avec succès';

            }elseif($operation == 1){

                $produit->statut = 2;
                $msg = 'Produit désactivé avec succès';
            }

            if($produit->save()){
                $data = [
                    'state' => 'ok',
                    'message' => $msg,
                ];
            }else{
               $data = [
                'state' => 'ko',
                'message' => 'Echec de l\'opération sur cet produit',
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
     * Deletes an existing Produit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSupprimer()
    {
        $produit = new Produit();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $produit = Produit::find()->where(['id'=>(int)$id])->one();

            $produit->statut = 0;

            if($produit->save()){
                $data = [
                    'state' => 'ok',
                    'message' => 'Produit supprimer avec succès',
                ];
            }else{
             $data = [
                'state' => 'ko',
                'message' => 'Echec de suppression du produit',
                'error' => $produit->getErrors(),
            ];
        }
        $class = $data['state']=='ok'? 'success':'error';
        $message = $data['message'];

        Yii::$app->getSession()->setFlash($class,$message);

        return json_encode($data);
    } 
}

    /**
     * Deletes an existing Produit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSelect($id)
    {
        $produit = new Produit();
        if(Yii::$app->request->isAjax){;
            $produit = Produit::find()->where(['id'=>(int)$id])->one();
            $produit->statut = 2;
            $produit->save();

            $categories = Categorie::find()->where('statut=1')->all();
            $this->layout = false;
            return $this->render('select', [
                'categories' => $categories,
            ]);
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
        if (($model = Produit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
