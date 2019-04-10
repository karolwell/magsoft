<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\User;
use backend\models\UserSearch;
use common\models\LoginForm;
use common\models\SignupForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
   /**
     * @inheritdoc
     */
   public function behaviors()
   {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['login','signup','utilisateurs','error','index'],
                    'allow' => true,
                ],
                [
                    'actions' => ['logout', 'login'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ],
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                    //'logout' => ['post'],
            ],
        ],
    ];
}

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->actionLogin();
        }

        return $this->render('index');
    }

    public function actionUtilisateurs()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->actionLogin();
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('utilisateurs', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionLogin()
    {
        set_time_limit(0);
        $this->layout="login_main";
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Merci de nous contactez. Nous vous répondrons dès que possible.');
            } else {
                Yii::$app->session->setFlash('error', 'Error d\'envoie de mail.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
             /* if (Yii::$app->getUser()->login($user)) {*/
                //return $this->goHome();
                Yii::$app->session->setFlash('success', 'Utilisateur ajouté avec succès');
            }else{
              Yii::$app->session->setFlash('error', 'Eche d\'ajout de l\'utilisateur'); 
          }
          /* }*/
      }

      return $this->render('signup', [
        'model' => $model,
    ]);
  }

  public function actionRequestPasswordReset()
  {
    $model = new PasswordResetRequestForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        if ($model->sendEmail()) {
            Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

            return $this->goHome();
        } else {
            Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
        }
    }

    return $this->render('requestPasswordResetToken', [
        'model' => $model,
    ]);
}

public function actionResetPassword($token)
{
    try {
        $model = new ResetPasswordForm($token);
    } catch (InvalidParamException $e) {
        throw new BadRequestHttpException($e->getMessage());
    }

    if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
        Yii::$app->getSession()->setFlash('success', 'New password was saved.');

        return $this->goHome();
    }

    return $this->render('resetPassword', [
        'model' => $model,
    ]);
}

public function actionGetcontrollersandactions()
{
    $controllerlist = [];
    if ($handle = opendir('../controllers')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                $controllerlist[] = $file;
            }
        }
        closedir($handle);
    }
    asort($controllerlist);
    $fulllist = [];
    foreach ($controllerlist as $controller):
        $handle = fopen('../controllers/' . $controller, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (preg_match('/public function action(.*?)\(/', $line, $display)):
                    if (strlen($display[1]) > 2):
                        $fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
                    endif;
                endif;
            }
        }
        fclose($handle);
    endforeach;
    print_r($fulllist);exit;
    return $fulllist;
}

}
