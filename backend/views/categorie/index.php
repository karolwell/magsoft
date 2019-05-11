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

$this->title = 'Liste des catégories';
$this->params['breadcrumbs'][] = ['label' => 'Produits', 'url' => ['produit/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script type="text/javascript">

    function doitMass(op){
        if(op == "supp"){
            var titre = "Suppression";
            var msg = "Vous êtes sur le point de supprimer ces catégories";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver ces catégories";
            }else{
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer ces catégories";

            }
        }
        var datas = [];
        $('#titre').html(titre);            
        $('#message').html(msg);  
        $('#type_operation').val(0);        
        $('#action').val(action);
        $('input:checked[name="selection[]"]').each(function() {
            datas.push($(this).val());
        });
        $('#id_element').val(datas);
    }   

    function doIt(op,id,state){

        $('#default_modal_body').removeClass('card-refresh');
        if(op == "supp"){
            var titre = "Suppression";
            var msg = "Vous êtes sur le point de supprimer cette catégorie";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 2){
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer cette catégorie";   
            }else if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver cette catégorie";
            }
        }

        $('#titre').html(titre);            
        $('#message').html(msg);  
        $('#type_operation').val(state);        
        $('#action').val(action);
        $('#id_element').val(id);
    }

    function do_operation(){
        $('#default_modal_body').addClass('card-refresh');
        var action=encodeURIComponent($('#action').val());

        var url_submit = "<?php echo Yii::$app->homeUrl ?>categorie/"+action;

        //var operation=encodeURIComponent($('#type_operation').val());
        var id_element=encodeURIComponent($('#id_element').val());
        var operation=encodeURIComponent($('#type_operation').val());

        $.ajax({
            url: url_submit,
            type: "POST",
            data: { 
                operation: operation,
                id: id_element,
            },
            success: function(data) {
                $('#default_modal_body').removeClass('card-refresh');
                location.reload(true);
            }
        });

    }
</script>

<script type="text/javascript">
    function addcategorieShow(){ 

        $('#addcategorie').show();
        $('#openAdd').hide();
        $('#closeAdd').show();
        //alert(form);
    }
    function addcategorieClose(){ 
        $('#closeAdd').hide();
        $('#openAdd').show();
        $('#addcategorie').hide();
        //alert(form);
    }

    function addCategorie(id){ 
        $('#datas').addClass('card-refresh');
        var inputs = {};

        inputs.id = $('#id').val();
        inputs.designation = $('#designation').val();
        inputs.description = $('#description').val();
        
        //jnputs.lien = $("#signupform-regionsid").get(0).options[0] = new Option("Chargement des regions", "-1");

        var url = "<?php echo Yii::$app->homeUrl ?>categorie/ajouter_categorie";

        $.ajax({
          url: url,
          type: "POST",
          data: {
            categorie: inputs,
        },
        success: function (data) {

          var datas = JSON.parse(data);

          if(datas.state=='ok'){
              $('#datas').removeClass('card-refresh');  
              location.reload(true);
          }else{
              $('#datas').removeClass('card-refresh');  
              location.reload(true);
          }

      }
  });
    }

    function modifcategorieShow(categorie) {
        var inputs = categorie.split("*");
        //alert(inputs);
        $('#id').val(inputs[0]);
        $('#designation').val(inputs[1]);
        $('#description').val(inputs[2]);
        addcategorieShow();
    }

    function details(id){
        $('#modal-lg').addClass('card-refresh');
        $('#content').html(' ');
        $('#detail-titre').html('Produit(s)');

        var url = "<?php echo Yii::$app->homeUrl ?>categorie/produits";

        $.ajax({
          url: url,
          type: "POST",
          data: {
            categorie: id,
        },
        success: function (data) {

            $('#modal-lg').removeClass('card-refresh');
            $('#content').html(data);


         }
        });

    }
</script>

<?= $this->render('../dialogue'); ?>
<?= $this->render('../details'); ?>

<div class="container-fluid">
    <div id="page" class="page-title">
        <h4>
            Liste des catégories
            <a id="openAdd" class="btn btn-info pull-right" href="#" onclick="addcategorieShow()"> <i class="fa fa-plus"></i> </a>
            <a id="closeAdd"  class="btn btn-info pull-right" href="#" onclick="addcategorieClose()" style="display: none;"> <i class="fa fa-close"></i> </a>
            <!-- <?= Html::a(Yii::t('app', 'Fermer <i class="fa fa-plus"></i>'), ['#'], ['class' => 'btn btn-info pull-right','style'=>'color:white;','onclick'=>'adduser()']) ?> -->
        </h4>
    </div>
    <div class="card" id="addcategorie" style="display: none;">
        <div class="card-block" id="form">
            <?php $form = ActiveForm::begin(['id' => 'form-menu']); ?>
            <?= $form->field($categorie, 'id')->textInput(['id'=>'id','type'=>'hidden'])->label(false)->error(false) ?>
            <div class="col-sm-3">      
                <?= $form->field($categorie, 'designation')->textInput(['placeholder'=>'Désignation','id'=>'designation'])->label('Désignation')->error(false) ?>
            </div>
            <div class="col-sm-8">      
                <?= $form->field($categorie, 'description')->textInput(['placeholder'=>'Description','id'=>'description'])->label('Description')->error(false) ?>
            </div>

            <div class="col-sm-1 form-group dropdown inline-block" style="margin-top: 2.2%;">     
                <?= Html::Button('<i class="fa fa-check"></i>', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'ass-button', 'onclick'=>'addCategorie(0);']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="datas" class="card">
                <div class="card-block">

                    <div class="table-overflow">

                        <?php Pjax::begin(); ?>
                        <table id="dt-opt" class="table table-sm table-hover table-stripped table-condensed">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="checkbox mrg-left-20">
                                            <input id="task" name="task" type="checkbox">
                                            <label for="task"></label>
                                        </div>
                                    </th>
                                    <th><div class="mrg-btm-15">Désignation</div></th>
                                    <th><div class="mrg-btm-15">description</div></th>
                                    <th><div class="mrg-btm-15">Utilisateur</div></th>
                                    <th><div class="mrg-btm-15">status</div></th>
                                    <th><div class="mrg-btm-15">Actions</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($categories): ?>

                                    <?php foreach ($categories as $categorie): ?>
                                        <tr id="catecorie_<?= $categorie->id ?>">
                                            <td>
                                                <div class="checkbox mrg-left-20">
                                                    <input id="task_<?= $categorie->id ?>" name="task[]" type="checkbox">
                                                    <label for="task_<?= $categorie->id ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $categorie->designation ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <!-- <span><?= Yii::$app->homeUrl.$categorie->designation ?></span> -->
                                                    <span><?= $categorie->description ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $categorie->createBy->username ?></span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="mrg-top-15" data-toggle="modal" data-target="#default-modal" title="" onclick="doIt('act','<?= $categorie->id ?>','<?= $categorie->statut ?>')">
                                                    <span>
                                                        <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                                                            <input id="status_<?= $categorie->id ?>" type="checkbox" name="toggle5"  <?= $categorie->statut == 1?'checked':'' ?> value="<?= $categorie->statut ?>" disabled>
                                                            <label for="status_<?= $categorie->id ?>"></label>
                                                        </div>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-20  font-size-18">
                                                    <a href="#" title="Modifier" onclick="modifcategorieShow('<?= $categorie->id."*".str_replace("'", "\'", $categorie->designation)."*".str_replace("'", "\'", $categorie->description) ?>')" ><span class="icon-holder"><i class="ti-pencil"></i></span></a>
                                                    <a href="#" data-toggle="modal" data-target="#default-modal" title="Supprimer" onclick="doIt('supp','<?= $categorie->id ?>','<?= $categorie->statut ?>')"><span class="icon-holder"><i class="ti-trash"></i></span></a>
                                                    <a href="#" data-toggle="modal" data-target="#modal-lg" title="Détails" onclick="details('<?= $categorie->id ?>')"><span class="icon-holder"><i class="ti-view-list"></i></span></a>
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
            </div>
        </div>
    </div>
</div>
