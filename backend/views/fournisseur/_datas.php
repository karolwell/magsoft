<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des fournisseurs';
//$this->params['breadcrumbs'][] = ['label' => 'Liste des ventes', 'url' => ['SortieClient/index']];
$this->params['breadcrumbs'][] = $this->title;
?> 
                <div class="card-block">

                    <div class="table-overflow">

                        <?php Pjax::begin(); ?>
                        <table id="dt-opt" class="table table-sm table-hover table-stripped table-condensed">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox mrg-left-20">
                                            <input id="task" name="task" type="checkbox" onclick="checkAll()">
                                            <label for="task"></label>
                                        </div>
                                    </th>
                                    <th><div class="mrg-btm-15">Nom</div></th>
                                    <th><div class="mrg-btm-15">Téléphone</div></th>
                                    <th><div class="mrg-btm-15">Email</div></th>
                                    <th><div class="mrg-btm-15">Adresse</div></th>
                                    <th><div class="mrg-btm-15">Mail</div></th>
                                    <th><div class="mrg-btm-15">Actions</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($fournisseurs): ?>

                                    <?php foreach ($fournisseurs as $fournisseur): ?>
                                        <tr id="fournisseur_<?= $fournisseur->id ?>">
                                            <td>
                                                <div class="checkbox mrg-left-20">
                                                    <input id="task_<?= $fournisseur->id ?>" class="_task" id="task_<?= $fournisseur->id ?>" name="task[]" type="checkbox" value="<?= $fournisseur->id ?>" onclick="checkSubtasks()">
                                                    <label for="task_<?= $fournisseur->id ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $fournisseur->nom ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $fournisseur->tel ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $fournisseur->email ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $fournisseur->adresse ?></span>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="mrg-top-15" data-toggle="modal" data-target="#default-modal" title="" onclick="doIt('act','<?= $fournisseur->id ?>','<?= $fournisseur->statut ?>')">
                                                    <span>
                                                        <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                                                            <input id="statut_<?= $fournisseur->id ?>" type="checkbox" name="toggle5"  <?= $fournisseur->statut == 1?'checked':'' ?> value="<?= $fournisseur->statut ?>" disabled>
                                                            <label for="statut_<?= $fournisseur->id ?>"></label>
                                                        </div>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-20 text-center font-size-18">
                                                    <a href="#" title="Modifier" onclick="modiffournisseurShow('<?= $fournisseur->id."*".str_replace("'", "\'", $fournisseur->nom)."*".$fournisseur->tel."*".str_replace("'", "\'", $fournisseur->email)."*".str_replace("'", "\'", $fournisseur->adresse) ?>')" ><span class="icon-holder"><i class="ti-pencil"></i></span></a>
                                                    <a href="#" data-toggle="modal" data-target="#default-modal" title="Supprimer" onclick="doIt('supp','<?= $fournisseur->id ?>','<?= $fournisseur->id ?>')"><span class="icon-holder"><i class="ti-trash"></i></span></a>
                                                    <a href="#" data-toggle="modal" data-target="#modal-lg" title="Les achats éffectués" onclick="details('<?= $fournisseur->id ?>')"><span class="icon-holder"><i class="ti-view-list"></i></span></a>
                                                    <!-- <button class="btn btn-icon btn-flat btn-rounded dropdown-toggle">
                                                        <i class="ti-more-alt"></i>
                                                    </button> -->
                                                </div>
                                            </td>
                                        </tr>  

                                    <?php endforeach ?>

                                <?php endif ?>

                            </tbody>
                        </table>
                        <?php Pjax::end(); ?>
                    </div>
                </div>