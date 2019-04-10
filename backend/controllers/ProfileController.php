<?php

namespace backend\controllers;

use Yii;
use backend\controllers\Common;
use backend\models\Profile;
use backend\models\Menu;
use backend\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
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
        if (in_array($action->id, ['ajouter_profile','supprimer','activer_desactiver','attribution_droit','droit_profile'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {

        $profile = new Profile();
        $profiles = $profile->find()->where('statut<>0')->all();

        return $this->render('index', [
            'profiles' => $profiles,
            'profile' => $profile,
        ]);
    }

    /**
     * Droit an existing Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionDroit(){

        $profile = new Profile();
        $menu = new Menu();

        $profiles = Profile::find()->where('statut<>0')->all();
        $menus = Menu::find()->where('statut<>0')->all();
        //print_r($profiles);exit;
        return $this->render('droit', [
            'profiles' => $profiles,
            'menus' => $menus,
        ]);

    }

    /**
     * Droit an existing Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionDroit_profile(){

        $profile = new Profile();
        $menu = new Menu();
        if(Yii::$app->request->isAjax){
        $id = Yii::$app->request->post()['id'];
        $profile = Profile::find()->where(['id'=>$id])->one();
        $menus = Menu::find()->where('statut<>0')->all();
        $droits = [];
        if($profile->droit){    
            $droit = json_decode($profile->droit);
            foreach ($droit as $key => $value) {
                $droits[$key] = $value;
            }
        }
        $droit_menus = array_keys($droits);
    /*        if(in_array('16', array_keys($droits))){
            $t = 1;
        }else{
            $t = 0;
        }*/
        //print_r($t);exit;
        $this->layout = false;
        return $this->render('_droit', [
            'profile' => $profile,
            'menus' => $menus,
            'droit_menus' => $droit_menus,
            'droit_sousmenus' => $droits,
        ]);
    }
    }


    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }



        /**
     * Creates a new profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
        public function actionAjouter_profile()
        {
            $profile = new Profile();
            if(Yii::$app->request->isAjax){
                $params = Yii::$app->request->post()['profile'];
                if($params['id']!=0){
                    $profile = Profile::find()->where(['id'=>(int)$params['id']])->one();
                } 


                if(!empty($params['designation'])){
                    foreach ($profile as $key => $value) {

                        if(isset($params[$key])){
                            $profile->$key=$params[$key];
                        }

                    }


                    if($profile->id){

                        if($profile->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'profile modifié avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec de modification du profile',
                        //'results'=>$profile->getErrors(),
                            ] ;
                        }

                    }else{
                        $exist = profile::find()->where(['designation'=>$profile->designation])->one();
                        if($exist && $exist->statut==0){
                            $exist->statut = 1;
                            if($exist->save()){
                                $data = [
                                    'state'=>'ok',
                                    'message'=>'profile enrégistré avec succès',
                                ] ;
                            }else{
                                $data = [
                                    'state'=>'ko',
                                    'message'=>'Echec d\'enrégistrement du profile',
                            //'results'=>$profile->getErrors(),
                                ] ;
                            }
                        }else{

                           if($profile->save()){
                            $data = [
                                'state'=>'ok',
                                'message'=>'profile enrégistré avec succès',
                            ] ;
                        }else{
                            $data = [
                                'state'=>'ko',
                                'message'=>'Echec d\'enrégistrement du profile',
                            //'results'=>$profile->getErrors(),
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
     * Activer_desactiver an existing Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionActiver_desactiver()
    {
        $profile = new Profile();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $operation = Yii::$app->request->post()['operation'];
            $profile = Profile::find()->where(['id'=>(int)$id])->one();
            if($operation == 2){

                $profile->statut = 1;
                $msg = 'Profile activé avec succès';

            }elseif($operation == 1){

                $profile->statut = 2;
                $msg = 'Profile désactivé avec succès';
            }

            if($profile->save()){
                $data = [
                    'state' => 'ok',
                    'message' => $msg,
                ];
            }else{
             $data = [
                'state' => 'ko',
                'message' => 'Echec de l\'opération sur ce profile',
                //'error' => $profile->getErrors(),
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
        $profile = new Profile();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $profile = Profile::find()->where(['id'=>(int)$id])->one();

            $profile->statut = 0;

            if($profile->save()){
                $data = [
                    'state' => 'ok',
                    'message' => 'Profile supprimer avec succès',
                ];
            }else{
             $data = [
                'state' => 'ko',
                'message' => 'Echec de suppression de profile',
                'error' => $profile->getErrors(),
            ];
        }
        $class = $data['state']=='ok'? 'success':'error';
        $message = $data['message'];

        Yii::$app->getSession()->setFlash($class,$message);

        return json_encode($data);
    } 
}

    /**
     * attribution_droit an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
    */
    public function actionAttribution_droit(){

        $profile = new Profile();
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post()['id'];
            $datas = Yii::$app->request->post()['niveaux'];
            $profile = Profile::find()->where(['id'=>(int)$id])->one();
            if($profile){
                $datas = explode('-', $datas);
                foreach ($datas as $key => $data) {
                    $temp = explode('*', $data);
                    if(isset($temp[1])){
                        $droits[$temp[0]] = $temp[1];
                    }else{
                        $droits[$temp[0]] = 0;
                    }
                }

                $profile->droit = json_encode($droits);

                if($profile->save()){
                    $data = [
                        'state' => 'ok',
                        'message' => 'Droits d\'accès attribués avec succès',
                    ];
                }else{
                    $data = [
                        'state' => 'ko',
                        'message' => 'Droits d\'accès non attribués',
                    ];
                }
            }else{
                $data = [
                    'state' => 'ko',
                    'message' => 'Vous devez choisir un profile',
                ];
            }
            
            //print_r(json_encode($droits));
            $class = $data['state']=='ok'? 'success':'error';
            $message = $data['message'];

            Yii::$app->getSession()->setFlash($class,$message);
        }

    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
