<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Enrégister un utilisateur';
$this->params['breadcrumbs'][] = ['label' => 'Liste', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12" style="margin-bottom: 5%;">
	<h4 class="card-title">Enrégister un nouvel utilisateur</h4>
    <div class="card">
        <div class="portlet">
            <ul class="portlet-item navbar">
                <li class="dropdown">
                    <a href="cards.html" class="btn btn-icon btn-flat btn-rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="ti-more"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="cards.html">
                                <i class="ti-files pdd-right-10"></i>
                                <span>Duplicate</span>
                            </a>
                        </li>
                        <li>
                            <a href="cards.html">
                                <i class="ti-smallcap pdd-right-10"></i>
                                <span>Edit</span>
                            </a>
                        </li>
                        <li>
                            <a href="cards.html">
                                <i class="ti-image pdd-right-10"></i>
                                <span>Add Images</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="btn btn-icon btn-flat btn-rounded" data-toggle="card-refresh">
                        <i class="ti-reload"></i>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="btn btn-icon btn-flat btn-rounded" data-toggle="card-delete">
                        <i class="ti-close"></i>
                    </a>
                </li>
            </ul>
        </div>
            
        <div class="card-block col-md-7">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username')->textInput(['placeholder'=>'Nom utilisateur'])->label('Nom utilisateur') ?>
            <?= $form->field($model, 'email')->passwordInput(['placeholder'=>'Email'])->label('Email') ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Mot de passe'])->label('Mot de passe') ?>
            <?= $form->field($model, 'password_confirm')->passwordInput(['placeholder'=>'Confirmez votre mot de passe'])->label('Confirmation') ?>
            
            <div class="form-group">
                <?= Html::submitButton('Enrégister', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
