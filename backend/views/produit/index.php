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

$this->title = 'Liste des produits';
$this->params['breadcrumbs'][] = ['label' => 'Mouvements', 'url' => ['produit/mouvements']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script type="text/javascript">

    function doitMass(op){
        if(op == "supp"){
            var titre = "Suppression";
            var msg = "Vous êtes sur le point de supprimer ces produits";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver ces produits";
            }else{
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer ces produits";

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
            var msg = "Vous êtes sur le point de supprimer cet produit";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 2){
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer cet produit";   
            }else if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver cet produit";
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

        var url_submit = "<?php echo Yii::$app->homeUrl ?>produit/"+action;

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
    function addproduitShow(){ 

        $('#addproduit').show();
        $('#openAdd').hide();
        $('#closeAdd').show();
        //alert(form);
    }
    function addproduitClose(){ 
        $('#closeAdd').hide();
        $('#openAdd').show();
        $('#addproduit').hide();
        //alert(form);
    }

    function addProduit(id){ 
        $('#datas').addClass('card-refresh');
        var inputs = {};

        inputs.id = $('#id').val();
        inputs.designation = $('#designation').val();
        inputs.prix = $('#prix').val();
        inputs.quantite_min = $('#quantite_min').val();
        inputs.quantite_max = $('#quantite_max').val();
        inputs.id_categorie = $('#selectize-dropdown').val();
        inputs.description = $('#description').val();
        
        //jnputs.lien = $("#signupform-regionsid").get(0).options[0] = new Option("Chargement des regions", "-1");

        var url = "<?php echo Yii::$app->homeUrl ?>produit/ajouter_produit";

        $.ajax({
          url: url,
          type: "POST",
          data: {
            produit: inputs,
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

    function modifproduitShow(produit) {
        var inputs = produit.split("*");
        //alert(inputs);
        $('#id').val(inputs[0]);
        $('#designation').val(inputs[1]);
        $('#prix').val(inputs[2]);
        $('#quantite_min').val(inputs[3]);
        $('#quantite_max').val(inputs[4]);
        //$('#selectize-dropdown').val(inputs[5]);
        //$("#selectize-dropdown").get(0).options.length = 0;
        $("#selectize-dropdown").get(0).options[0] = new Option(inputs[5], "0");
        $('#description').val(inputs[6]);
        addproduitShow();
    }

    function details(id){
        $('#modal-lg').addClass('card-refresh');
        $('#content').html(' ');
        $('#detail-titre').html('Détails');

        var url = "<?php echo Yii::$app->homeUrl ?>produit/mouvements";

        $.ajax({
          url: url,
          type: "POST",
          data: {
            produit: id,
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
            Liste des produits
            <a id="openAdd" class="btn btn-info pull-right" href="#" onclick="addproduitShow()"> <i class="fa fa-plus"></i> </a>
            <a id="closeAdd"  class="btn btn-info pull-right" href="#" onclick="addproduitClose()" style="display: none;"> <i class="fa fa-close"></i> </a>
            <!-- <?= Html::a(Yii::t('app', 'Fermer <i class="fa fa-plus"></i>'), ['#'], ['class' => 'btn btn-info pull-right','style'=>'color:white;','onclick'=>'adduser()']) ?> -->
        </h4>
    </div>
    <div class="card" id="addproduit" style="display: none;">
        <div class="card-block" id="form">
            <?php $form = ActiveForm::begin(['id' => 'form-menu']); ?>
            <?= $form->field($produit, 'id')->textInput(['id'=>'id','type'=>'hidden'])->label(false)->error(false) ?>
            <div class="col-sm-2">      
                <?= $form->field($produit, 'designation')->textInput(['placeholder'=>'Désignation','id'=>'designation'])->label('Désignation')->error(false) ?>
            </div>
            <div class="col-sm-2">      
                <?= $form->field($produit, 'prix')->textInput(['placeholder'=>'Prix','id'=>'prix'])->label('Prix')->error(false) ?>
            </div>
            <div class="col-sm-1">      
                <?= $form->field($produit, 'quantite_min')->textInput(['placeholder'=>'Quantité minimum','id'=>'quantite_min'])->label('Minimum')->error(false) ?>
            </div>
            <div class="col-sm-1">      
                <?= $form->field($produit, 'quantite_max')->textInput(['placeholder'=>'Quantité maximum','id'=>'quantite_max'])->label('Maximum')->error(false) ?>
            </div>
            <div class="col-sm-2">
                <div class="mrg-top-0">
                    <label>Catégorie</label>
                    <select id="selectize-dropdown" placeholder="Selectionnez la catégorie ...">
                        <option value="" disabled selected><span id="select" ></span></option>
                        <?php foreach ($categories as $key => $categorie): ?>
                                    <option value="<?= $categorie->id ?>"><?= $categorie->designation ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">      
                <?= $form->field($produit, 'description')->textInput(['placeholder'=>'Description','id'=>'description'])->label('Description')->error(false) ?>
            </div>
            <div class="col-sm-1 form-group dropdown inline-block" style="margin-top: 2.2%;">     
                <?= Html::Button('<i class="fa fa-check"></i>', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'ass-button', 'onclick'=>'addProduit(0);']) ?>
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
                                    <th><div class="mrg-btm-15">Prix (CFA)</div></th>
                                    <th><div class="mrg-btm-15">Min</div></th>
                                    <th><div class="mrg-btm-15">Max</div></th>
                                    <th><div class="mrg-btm-15">Quantité</div></th>
                                    <th><div class="mrg-btm-15">Description</div></th>
                                    <th><div class="mrg-btm-15">Catégorie</div></th>
                                    <th><div class="mrg-btm-15">Utilisateur</div></th>
                                    <th><div class="mrg-btm-15">Status</div></th>
                                    <th><div class="mrg-btm-15">Actions</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($produits): ?>

                                    <?php foreach ($produits as $produit): ?>
                                        <tr id="produit_<?= $produit->id ?>">
                                            <td>
                                                <div class="checkbox mrg-left-20">
                                                    <input id="task_<?= $produit->id ?>" name="task[]" type="checkbox">
                                                    <label for="task_<?= $produit->id ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $produit->designation ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $produit->prix ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $produit->quantite_min ?></span>
                                                </div>
                                            </td>
                                           <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $produit->quantite_max ?></span>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $produit->quantite ?></span>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="mrg-top-15">
                                                    <!-- <span><?= Yii::$app->homeUrl.$produit->designation ?></span> -->
                                                    <span><?= $produit->description ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <!-- <span><?= Yii::$app->homeUrl.$produit->designation ?></span> -->
                                                    <span><?= $produit->categorie->designation ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $produit->createBy->username ?></span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="mrg-top-15" data-toggle="modal" data-target="#default-modal" title="" onclick="doIt('act','<?= $produit->id ?>','<?= $produit->statut ?>')">
                                                    <span>
                                                        <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                                                            <input id="statut_<?= $produit->id ?>" type="checkbox" name="toggle5"  <?= $produit->statut == 1?'checked':'' ?> value="<?= $produit->statut ?>" disabled>
                                                            <label for="statut_<?= $produit->id ?>"></label>
                                                        </div>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-20  font-size-18">
                                                    <a href="#" title="Modifier" onclick="modifproduitShow('<?= $produit->id."*".str_replace("'", "\'", $produit->designation)."*".$produit->prix.'*'.$produit->quantite_min.'*'.$produit->quantite_max.'*'.$produit->categorie->designation.'*'.str_replace("'", "\'", $produit->description) ?>')" ><span class="icon-holder"><i class="ti-pencil"></i></span></a>
                                                    <a href="#" data-toggle="modal" data-target="#default-modal" title="Supprimer" onclick="doIt('supp','<?= $produit->id ?>','<?= $produit->statut ?>')"><span class="icon-holder"><i class="ti-trash"></i></span></a>
                                                    <a href="#" data-toggle="modal" data-target="#modal-lg" title="Détails" onclick="details('<?= $produit->id ?>')"><span class="icon-holder"><i class="ti-view-list"></i></span></a>
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
