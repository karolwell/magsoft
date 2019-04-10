<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SousMenu */

$this->title = 'Update Sous Menu: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sous Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sous-menu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
