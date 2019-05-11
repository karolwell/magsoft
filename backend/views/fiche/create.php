<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Fiche */

$this->title = 'Create Fiche';
$this->params['breadcrumbs'][] = ['label' => 'Fiches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fiche-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
