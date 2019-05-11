<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Produit */

$this->title = 'Create Produit';
$this->params['breadcrumbs'][] = ['label' => 'Produits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
