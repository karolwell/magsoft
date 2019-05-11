<?php

namespace backend\controllers;

use Yii;
use backend\models\Categorie;
use backend\models\Produit;
use backend\models\EntreeStock;
use backend\models\Fournisseur;
use backend\models\Fiche;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EntreestockController implements the CRUD actions for EntreeStock model.
 */
class EntreestockController extends Controller
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
    if (in_array($action->id, ['ajout_stock','activer_desactiver','details','supprimer'])) {
        $this->enableCsrfValidation = false;
    }
    return parent::beforeAction($action);
}


    /**
     * Lists all EntreeStock models.
     * @return mixed
     */
    public function actionIndex()
    {
       $entreeStock = new EntreeStock();
       $entreeStocks = EntreeStock::find()->where('statut<>0')->groupby('reference')->all();
       $categories = Categorie::find()->where('statut<>0')->all();
       $fournisseurs = Fournisseur::find()->where('statut<>0')->all();
       //print_r($entreeStocks);exit;

       return $this->render('index', [
        'entreeStocks' =>$entreeStocks,
        'entreeStock' =>$entreeStock,
        'categories' => $categories,
        'fournisseurs' => $fournisseurs,
    ]);
   }

    /**
     * Displays a single EntreeStock model.
     * @param integer $reference
     * @return mixed
     */
    public function actionDetails()
    {
        $entreeStock = new EntreeStock();
        if(Yii::$app->request->isAjax){
            $ref = Yii::$app->request->post()['reference'];
            $entreeStocks = EntreeStock::find()->where(['reference'=>$ref])->andWhere('statut<>0')->all();

            $this->layout = false;
            return $this->render('view', [
                'entreeStocks' => $entreeStocks,
            ]);
        }

    }

    /**
     * Creates a new EntreeStock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAjout_stock()
    {
        $fiche = new Fiche();
        if(Yii::$app->request->isPost){
            $infos = Yii::$app->request->post();
            $produits = $infos['id_produits'];
            $fournisseurs = $infos['id_fournisseurs'];
            $quantites = $infos['quantites'];
            $reference = Yii::$app->security->generateRandomString(32); 
            //print_r($infos);exit;
            foreach ($produits as $key => $produit) {

               $entreeStock = new EntreeStock();
               $entreeStock->reference = $reference;
               $entreeStock->id_produit = $produits[$key];
               $entreeStock->quantite = $quantites[$key];
               $entreeStock->id_fournisseur = $fournisseurs[$key];
               $entreeStock->date_create = date('Y-m-d H:i:s');
               $entreeStock->create_by = Yii::$app->user->identity->id;
               $produit = Produit::find()->where(['id'=>$entreeStock->id_produit])->one();
               $produit->quantite += $entreeStock->quantite;
               $produit->save();
               $entreeStock->save();
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
            $this->redirect(['entreestock/index']);
        }
    }


    /**
     * Creates a new EntreeStock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAjout_stock_()
    {
     $entreeStock = new EntreeStock();
     if(Yii::$app->request->isAjax){
        $params = Yii::$app->request->post()['produit'];
        if($params['id']!=0){
         $entreeStock = EntreeStock::find()->where(['id'=>(int)$params['id']])->one();
     } 
            //exit;
     if(!empty($params['designation'])){
        foreach ($entreeStock as $key => $value) {

            if(isset($params[$key])){
             $entreeStock->$key=$params[$key];
         }

     }


     if($entreeStock->id){
         $entreeStock->date_update = date('Y-m-d H:i:s');
         $entreeStock->update_by = Yii::$app->user->identity->id;
         if($entreeStock->save()){
            $data = [
                'state'=>'ok',
                'message'=>'Ravitaillement modifié avec succès',
            ] ;
        }else{
            $data = [
                'state'=>'ko',
                'message'=>'Echec de modification du Ravitaillement',
                        //'results'=>$menu->getErrors(),
            ] ;
        }

    }else{
        $exist = EntreeStock::find()->where(['reference'=>$entreeStock->reference,'id_produit'=>$entreeStock->id_produit])->one();
        if($exist && $exist->statut==0){
            $exist->statut = 1;
            $entreeStock->date_update = date('Y-m-d H:i:s');
            $entreeStock->update_by = Yii::$app->user->identity->id;
            if($exist->save()){
                $data = [
                    'state'=>'ok',
                    'message'=>'Ravitaillement enrégistré avec succès',
                ] ;
            }else{
                $data = [
                    'state'=>'ko',
                    'message'=>'Echec d\'enrégistrement du ravitaillement',
                            //'results'=>$menu->getErrors(),
                ] ;
            }
        }else{
         $entreeStock->date_create = date('Y-m-d H:i:s');
         $entreeStock->create_by = Yii::$app->user->identity->id;
         if($entreeStock->save()){
            $data = [
                'state'=>'ok',
                'message'=>'Ravitaillement enrégistré avec succès',
            ] ;
        }else{
            $data = [
                'state'=>'ko',
                'message'=>'Echec d\'enrégistrement du ravitaillement',
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
     $entreeStock = new $EntreeStock();
     if(Yii::$app->request->isAjax){
        $id = Yii::$app->request->post()['id'];
        $operation = Yii::$app->request->post()['operation'];
        $entreeStock = EntreeStock::find()->where(['id'=>(int)$id])->one();
        if($operation == 2){

         $entreeStock->statut = 1;
         $msg = 'Ravitaillement activé avec succès';

     }elseif($operation == 1){

         $entreeStock->statut = 2;
         $msg = 'Ravitaillement désactivé avec succès';
     }

     if($entreeStock->save()){
        $data = [
            'state' => 'ok',
            'message' => $msg,
        ];
    }else{
     $data = [
        'state' => 'ko',
        'message' => 'Echec de l\'opération sur cet ravitaillement',
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
     $entreeStock = new $EntreeStock();
     if(Yii::$app->request->isAjax){
        $id = Yii::$app->request->post()['id'];
        $entreeStock = EntreeStock::find()->where(['id'=>(int)$id])->one();

        $entreeStock->statut = 0;

        if($entreeStock->save()){
            $data = [
                'state' => 'ok',
                'message' => 'Ravitaillement supprimé avec succès',
            ];
        }else{
           $data = [
            'state' => 'ko',
            'message' => 'Echec de suppression du ravitaillement',
            'error' =>$entreeStock->getErrors(),
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
        if (($model = EntreeStock::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
