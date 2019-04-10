<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Connexion';
$form = ActiveForm::begin(); 
//$this->params['breadcrumbs'][] = $this->title;
?>


<!-- login form -->
<div>

    <div class="connexion">

        
        <form action="" method="post" name="_csrf" class="sky-form boxed">
            <input type="hidden" name="_csrf" value="TlNpc3kuVVF3NScxEgMNMx1gPDEhGWw7GD4uQQ1rNxAIKkRFTHw7Ig==">
            <h2 style="color: #AAA; margin-bottom: 5%;"><i class="fa fa-users"></i> Connectez-vous !</h2>


                            <?= $form->field($model, 'username')->textInput(['placeholder'=>'Utilisateur','class'=>'input'])->Label(false); ?>

                        
                            <i class="icon-append fa fa-lock"></i>
                            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Mot de passe','class'=>'input'])->Label(false); ?>
                       
                        <label style="color: #AAA;" class="checkbox_"><input name="rememberMe" type="checkbox" name="checkbox-inline" checked><i></i> <span style="margin-right: 5px;">Restez connecter</span> </label>


                <footer class="text-center">
                    <button type="submit" class="btn btn-primary col-lg-10" style="margin-top: 15px;">Connexion</button>
                    <div class="forgot-password pull-left">

                        </div>
                    </footer>
                </form>
                

            </div>

 </div>