<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modal fade" id="default-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="pull-left" id="titre"></h4>
                 <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="default_modal_body">
                <p id="message">...</p>
                <input type="hidden" value="0"  name="action" id="action"  />
                <input type="hidden" value="0"  name="type_operation" id="type_operation"  />
                <input type="hidden" value="0"  name="id_element" id="id_element"  /> 
            </div>
            <div class="modal-footer no-border">
                <div class="text-right">
                    <button class="btn btn-default btn-sm" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-warning btn-sm" onclick="do_operation();">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

