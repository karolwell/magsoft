<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SortieStock */

$this->title = 'Create Sortie Stock';
$this->params['breadcrumbs'][] = ['label' => 'Sortie Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sortie-stock-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
