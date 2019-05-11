<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SortieStock */

$this->title = 'Update Sortie Stock: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sortie Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sortie-stock-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
