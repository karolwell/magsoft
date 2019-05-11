<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Fournisseur */

$this->title = 'Create Fournisseur';
$this->params['breadcrumbs'][] = ['label' => 'Fournisseurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fournisseur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
