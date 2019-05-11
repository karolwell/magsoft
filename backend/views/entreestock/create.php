<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\EntreeStock */

$this->title = 'Create Entree Stock';
$this->params['breadcrumbs'][] = ['label' => 'Entree Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entree-stock-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
