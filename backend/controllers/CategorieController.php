<?php

namespace backend\controllers;

use Yii;
use common\models\Categorie;
use common\models\CategorieSearch;
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

    /**
     * Lists all Categorie models.
     * @return mixed
     */
    public function actionIndex()
    {

      if (\Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    $searchModel = new CategorieSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}

    /**
     * Displays a single Categorie model.
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
     * Creates a new Categorie model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      if (\Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    $model = new Categorie();

       //Yii::$app->session->setFlash('info', 'Veuillez remplir dumment le formulaire');

    if ($model->load(Yii::$app->request->post())) {
        $model->date = @date('Y-m-d H:m:i');

        $categorie = Yii::$app->request->post()['Categorie'];
        $libelle=$categorie['libelle'];
        $exist = $model->findOne(['libelle'=>$libelle]);

        if (sizeof($exist)==0) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Categorie bien enrégistrée');
            //return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Categorie non enrégistrée'); 
            }
        }else {
            Yii::$app->session->setFlash('error', 'Categorie non enrégistrée'); 
        }
    }

    return $this->render('create', [
        'model' => $model,
    ]);
}

    /**
     * Updates an existing Categorie model.
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

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->id]);
    } else {
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}

    /**
     * Deletes an existing Categorie model.
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
     * Finds the Categorie model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categorie the loaded model
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
