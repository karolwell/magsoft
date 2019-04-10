<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = ['label' => 'Ajouter', 'url' => ['create']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container-fluid">
    <div class="page-title">
        <h4>Liste des utilisateurs</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    <div class="pull-left col-md-3">
                        <?= Html::a(Yii::t('app', 'Nouveau <i class="fa fa-plus"></i>'), ['signup'], ['class' => 'btn btn-info ','style'=>'color:white;']) ?>
                    </div>
                    <div class="table-overflow">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
                            'layout' => '{items}{pager}',

                            'tableOptions' => [
                                'class' => 'table table-lg table-hover','id'=>'dt-opt' 
                            ], 

                            'columns' => [
                                [
                                    'class' => 'yii\grid\CheckboxColumn',
                                    'checkboxOptions' => function ($data) {
                                        return ['value' => $data->auth_key];
                                    }
                                ],

                                //'id',

                                [
                                    'label' => 'Utilisateur',
                                    'value' => 'username',                                                             
                                ],
                                [
                                    'label' => 'Email',
                                    'value' => 'email',                                                             
                                ],
                                //'password_hash',
                                [
                                    'label' => 'Date',
                                    'value' =>  function ($data) {
                                        return ['value' => $data->auth_key];
                                    },                                                             
                                ],
                                //'created_at:datetime',

                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>