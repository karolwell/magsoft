<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div style="margin-top: 5%;" class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="mrg-btm-20 mrg-top-1" id="detail-titre"></h3>
                <div>
                    <div class="row">
                        <div class="ml-auto col-md-12">
                            <div id="content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

