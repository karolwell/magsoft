<?php

namespace backend\controllers;

use Yii;
use yii\web\UploadedFile;
use common\models\Article;
use common\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritdoc
     */
    $i=0;
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

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
       if (\Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    $searchModel = new ArticleSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       if (\Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    return $this->render('view', [
        'model' => $this->findModel($id),
    ]);
}

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       if (\Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    $model = new Article();
    $model->setScenario('create');

        //Yii::$app->session->setFlash('info', 'Veuillez remplir dumment le formulaire');
    if ($model->load(Yii::$app->request->post())) {

        $model->date = @date('Y-m-d H:m:i');
        $model->images = UploadedFile::getInstances($model, 'images');

            //print_r($model->images);exit();

        $img = $model->upload();
        
        if ( $img) {
            foreach ($img as $key => $value) {
                $model->$key = $value->name;

                }//exit;
                //print_r($model->image3); exit;

                if ($model->save()) {

                    Yii::$app->session->setFlash('success', 'Article bien enrégistré');
                //return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Article non enrégistré');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

       if (\Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    $model = $this->findModel($id);

        

    if ($model->load(Yii::$app->request->post())) { 
    //print_r($model);exit();

        $model->date = @date('Y-m-d H:m:i');
        $model->images = UploadedFile::getInstances($model, 'images');
        //$model->image1 = 'default';

            //print_r($model->images);exit();

        $img = $model->upload();

        if ($img) {

            foreach ($img as $key => $value) {
                $key == 0 ? $key =1 : $key;
                $temp = 'image'.$key;
                $model->$temp = $value->name;
            }
        }

        if ($model->save()) {

            Yii::$app->session->setFlash('success', 'Article a  été mise à jour');
            return $this->redirect(['view', 'id' => $model->id]);
                //return $this->redirect(['view', 'id' => $model->id]);
        } else {
           Yii::$app->session->setFlash('error', 'Article n\'a pas été mise à jour');
       }


   }
   return $this->render('update', [
    'model' => $model,
]);

}

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       if (\Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }
    
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
}

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
