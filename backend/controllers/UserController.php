<?php

namespace backend\controllers;

use Yii;
//use backend\controllers\Common;
use backend\models\User;
use backend\models\Profile;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
        if (in_array($action->id, ['ajouter_utilisateur','activer_desactiver','supprimer','details'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        //print_r(Yii::$app->controller->action->controller->module->requestedRoute); exit;
        /*$searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);*/

        $user = new User();
        $users = $user->find()->where('status<>0')->all();
        $profiles = Profile::find()->where('statut<>0')->all();

        return $this->render('index', [
            'users' => $users,
            'user' => $user,
            'profiles' => $profiles,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetails()
    {
        $user = new User();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['user'];
            $user = User::find()->where(['id'=>(int)$id])->one();

            $this->layout = false;
            return $this->render('view', [
                'user' => $user,
            ]);
        }

    }

 /**
     * Creates a new user model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
 public function actionAjouter_utilisateur()
 {
    $user = new User();
    if(Yii::$app->request->isAjax){
        $params = Yii::$app->request->post()['user'];
        if($params['id']!=0){
            $user = User::find()->where(['id'=>(int)$params['id']])->one();
            } //exit;
            if(!empty($params['username'])){
                foreach ($user as $key => $value) {
                    if(isset($params[$key])){
                        $user->$key = $params[$key];
                    }
                }


                if($user->id){
                    if(!empty($user->password)){ 
                        $user->password_hash = (string)Yii::$app->security->generatePasswordHash(trim($user->password));
                    }
                    $user->updated_at = time();
                    if($user->save()){
                        $data = [
                            'state'=>'ok',
                            'message'=>'Utilisateur modifié avec succès',
                        ] ;
                    }else{
                        $data = [
                            'state'=>'ko',
                            'message'=>'Echec de modification de l\'utilisateur',
                        //'results'=>$menu->getErrors(),
                        ] ;
                    }

                }else{
                    $exist = User::find()->where(['username'=>$user->username])->one();
                    if($exist && $exist->statut==0){
                        $exist->status = 10;
                        if($exist->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'Utilisateur enrégistré avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement du utilisateur',
                            //'results'=>$menu->getErrors(),
                            ] ;
                        }
                    }else{
                       $user->auth_key = Yii::$app->security->generateRandomString(32);
                       $user->password_hash = (string)Yii::$app->security->generatePasswordHash(trim($user->password));
                       $user->created_at = time();

                       if($user->password == $user->password_confirm){
                           if($user->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'utilisateur enrégistré avec succès',
                            ] ;
                            }else{
                                $data = [
                                    'state'=>'ko',
                                    'message'=>'Echec d\'enrégistrement de l\' utilisateur',
                                    //'results'=>$user->getErrors(),
                                ] ;
                            }
                    }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Les mots de passes ne sont pas identiques',
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
     * Deletes an existing profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActiver_desactiver()
    {
        $user = new User();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $operation = Yii::$app->request->post()['operation'];
            $user = User::find()->where(['id'=>(int)$id])->one();
            if($operation == 11){

                $user->status = 10;
                $msg = 'utilisateur  activé avec succès';

            }elseif($operation == 10){

                $user->status = 11;
                $msg = 'utilisateur désactivé avec succès';
            }

            if($user->save()){
                $data = [
                    'state' => 'ok',
                    'message' => $msg,
                ];
            }else{
             $data = [
                'state' => 'ko',
                'message' => 'Echec de l\'opération sur cet utilisateur',
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
     * Deletes an existing profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSupprimer()
    {
        $user = new User();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $user = User::find()->where(['id'=>(int)$id])->one();

            $user->status  = 0;

            if($user->save()){
                $data = [
                    'state' => 'ok',
                    'message' => 'Utilisateur supprimer avec succès',
                ];
            }else{
               $data = [
                'state' => 'ko',
                'message' => 'Echec de suppression de l\'utilisateur',
                'error' => $user->getErrors(),
            ];
        }
        $class = $data['state']=='ok'? 'success':'error';
        $message = $data['message'];

        Yii::$app->getSession()->setFlash($class,$message);

        return json_encode($data);
    } 
}


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
