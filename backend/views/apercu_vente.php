<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
$fiche = new backend\models\Fiche();
?>

<div style="margin-top: 2%;" class="modal fade modal" id="modal-apercu" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-body height-">
                <!-- <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">×</button -->
                <a class="modal-close pull-right" href="" data-dismiss="modal">
                    <i class="ti-close"></i>
                </a>
                <h3 class="mrg-btm-20 mrg-top-1" id="detail-titre"></h3>
                <div class="row vertical-align text-justify">
                    <?php $form = ActiveForm::begin(['id' => 'form-Stock', 'method'=>'Post','action'=>Yii::$app->homeUrl.'sortiestock/sortie_stock','options'=>['entype'=>'multipart/form-data']]); ?>
                    <div id="new-datas" class="col-md-12">

                    </div>
                    <div class="form-group col-md-12">
                        <label>Joindre la fiche justificative de la vente</label>
                        <div class="custom-file" style="">
                            <!-- <input type="file" class="custom-file-input form-control" id="inputGroupFile02"> -->
                            <?= $form->field($fiche, 'file')->textInput(['type'=>'file','class' => 'custom-file-input form-control','id'=>'inputGroupFile02']) ?>
                            <label class="custom-file-label" for="inputGroupFile02">Choisir le fichier</label>
                        </div>
                        <?= Html::submitButton('<b>Ajouter</b>', ['class' => 'btn btn-warning col-md-5 pull-right']) ?>
                    </div>
                    <?php ActiveForm::end(); ?></form>
                </div>
            </div>
        </div>
    </div>
</div>
