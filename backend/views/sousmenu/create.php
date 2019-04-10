<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SousMenu */

$this->title = 'Create Sous Menu';
$this->params['breadcrumbs'][] = ['label' => 'Sous Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sous-menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
