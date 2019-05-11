<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use backend\models\Produit;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des ravitaillements';
$this->params['breadcrumbs'][] = ['label' => 'Mouvements', 'url' => ['produit/mouvements']];
$this->params['breadcrumbs'][] = $this->title;

?>

<script type="text/javascript">

    function doitMass(op){
        if(op == "supp"){
            var titre = "Suppression";
            var msg = "Vous êtes sur le point de supprimer ces mouvements d'entré en stock";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver ces mouvements d'entré en stock";
            }else{
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer ces mouvements d'entré en stock";

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
            var msg = "Vous êtes sur le point de supprimer cet mouvement d'entré en stock";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 2){
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer cet mouvement d'entré en stock";   
            }else if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver cet mouvement d'entré en stock";
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

        var url_submit = "<?php echo Yii::$app->homeUrl ?>entreestock/"+action;

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

    function effacer () {
      $(':input','#form')
      .not(':button, :submit, :reset, :hidden')
      .val('')
      .removeAttr('checked')
      .removeAttr('selected');

/*      $('#selectize-group.item').text('');
      $("#selectize-group.selected").addClass('grise');*/
      $('#id').val('');
      $('#quantite').val('');
      $('#selectize-group').val('');
      $('#selectize-dropdown').val('-');

  }  

  function addravitaillementShow(){ 

    $('#addravitaillement').show();
    $('#openAdd').hide();
    $('#closeAdd').show();
        //alert(form);
    }
    function addravitaillementClose(){ 
        $('#closeAdd').hide();
        $('#openAdd').show();
        $('#addravitaillement').hide();
        //alert(form);
    }

    var i=0;
    function newItem(){
        var inputs = {};
        var item = "...";
        inputs.id = $('#id').val();
        inputs.quantite = $('#quantite').val();
        inputs.id_produit = $('#selectize-group').val();
        inputs.id_fournisseur = $('#selectize-dropdown').val();
        
        if(inputs.quantite==null||inputs.id_produit==null||inputs.quantite==""||inputs.id_fournisseur==""){
            $('#notice').show();
        }else{

            $('#new').show();
            $('#new').addClass('card-refresh');

            var id_produit = inputs.id_produit.split("*")[0];
            var produit = inputs.id_produit.split("*")[1];

        if(inputs.id_fournisseur==null){
            var fournisseur="-";
            var id_fournisseur="";
        }else{
            var id_fournisseur = inputs.id_fournisseur.split("*")[0];
            var f = inputs.id_fournisseur.split("*")[1];
            if(f===undefined){var fournisseur="-"}else{ var fournisseur = f }

        }
        if(inputs.id===undefined){ item = inputs.id;}


        i += 1;
        var n = $('.itemm').length-1;
        if(n>=7){
            $('#items').addClass('flow');
        }else{
            $('#items').removeClass('flow');
        }
        var row = "<tr  id=\'item_"+i+"\' class='itemm'><td>#</td><td id=\'prod_"+i+"\'>"+produit+"<input type='hidden' name='id_produits[]' value=\'"+id_produit+"\'></td><td>"+inputs.quantite+" <input type='hidden' name='quantites[]' value=\'"+inputs.quantite+"\'></td><td>"+fournisseur+" <input type='hidden' name='id_fournisseurs[]' value=\'"+id_fournisseur+"\'><!--<td style='width:20px; font-size:18px;'><a href='#form' onclick=modifItem(\'"+i+"\',\'"+inputs.quantite+"\',\'"+id_produit+"\',\'"+id_fournisseur+"\')><span style='color:#4b5261;' class='icon-holder'><i class='ti-pencil'></i></span></a></td>--><td style='width:20px; color:#f5a32a; font-size:18px;'><a onclick=removeItem(\'"+i+"\')><span class='icon-holder'><i class='ti-trash'></i></span></a></td></tr>";
        $('.newitem').append(row);
        $('#new').removeClass('card-refresh');
        $('#notice').hide();

        effacer();
    }
}

function removeItem(id){

    $("#item_"+id).remove();
    var n = $('.itemm').length-1;
    if(n>=7){
        $('#items').addClass('flow');
    }else{
        $('#items').removeClass('flow');
    }
}

function modifItem(k,q,p,f) {
    alert(k);
    var designation_produit = $('#prod_'+k).text();
    var prod_select = p+'*'+designation_produit;
    $(".itemm").removeClass('grise');
    $("#item_"+k).addClass('grise');
    $('#id').val(k);
    $('#quantite').val(q);
    $('#selectize-group option[value="'+prod_select+'"]').prop('selected', true);
    //$('#selectize-group').val(prod_select).change();
    $('#selectize-dropdown').val(f);
    //$('#moteur option[value="essence"]').prop('selected', true);
}

function addRavitaillement(id){ 
    $('#datas').addClass('card-refresh');
    var inputs = {};

    inputs.id = $('#id').val();
    inputs.quantite = $('#designation').val();
    inputs.id_produit = $('#selectize-group').val();
    inputs.id_fournisseur = $('#selectize-dropdown').val();

        //jnputs.lien = $("#signupform-regionsid").get(0).options[0] = new Option("Chargement des regions", "-1");

        var url = "<?php echo Yii::$app->homeUrl ?>entreestock/ajout_stock";

        $.ajax({
          url: url,
          type: "POST",
          data: {
            ravitaillement: inputs,
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

    function modifravitaillementShow(ravitaillement) {
        var inputs = ravitaillement.split("*");
        //alert(inputs);
        $('#id').val(inputs[0]);
        $('#quantite').val(inputs[1]);
        $('#selectize-group').val(inputs[2]);
        $('#selectize-dropdown').val(inputs[3]);
        addravitaillementShow();
    }

    function details(ref){
        $('#modal-lg').addClass('card-refresh');
        $('#content').html(' ');
        $('#detail-titre').html('Détails');

        var url = "<?php echo Yii::$app->homeUrl ?>entreestock/details";

        $.ajax({
          url: url,
          type: "POST",
          data: {
            reference: ref,
        },
        success: function (data) {

            $('#modal-lg').removeClass('card-refresh');
            $('#content').html(data);


        }
    });

    }

   function cloturer(){
    var datas = $('#items').html();
    $('#new-datas').html(datas);
   }
</script>

<?= $this->render('../dialogue'); ?>
<?= $this->render('../details'); ?>
<?= $this->render('../apercu_ravitaillement'); ?>

<div class="container-fluid">
    <div id="page" class="page-title">
        <h4>
            Liste des ravitaillements
            <a id="openAdd" class="btn btn-info pull-right" href="#" onclick="addravitaillementShow()"> <i class="fa fa-plus"></i> </a>
            <a id="closeAdd"  class="btn btn-info pull-right" href="#" onclick="addravitaillementClose()" style="display: none;"> <i class="fa fa-close"></i> </a>
            <!-- <?= Html::a(Yii::t('app', 'Fermer <i class="fa fa-plus"></i>'), ['#'], ['class' => 'btn btn-info pull-right','style'=>'color:white;','onclick'=>'adduser()']) ?> -->
        </h4>
    </div>
    <div class="card" id="addravitaillement" style="display: none;">
        <div id="new" style="padding: 2%; margin-bottom: -5%; display: none;" >
            <div id="items" class="" style="">   
                <table  class="table table-bordered_ table-sm table-hover table-stripped table-condensed">
                    <thead><tr><td>#</td><td>Produit</td><td>Quantité</td><td>Fournisseur</td></tr></thead>
                    <tbody class="newitem"></tbody>
                </table>
            </div>
            <div class="col-sm-1 form-group dropdown inline-block pull-right" style="margin-top: 0%;">     
                <?= Html::Button('Cloturer <i class="fa fa-check"></i>', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'ass-button', 'data-toggle' => 'modal', 'data-target' => '#modal-apercu', 'onclick'=>'cloturer();']) ?>
            </div>
        </div>
        <div class="card-block" id="form" style="margin-top: -2%;">
            <div id="notice" class="alert-warning alert fade in mrg-top-40" style="display: none;">
                <button type="button" class="close" data-dismiss="alert_" aria-hidden="true">×</button>
                Veuillez renseigner le produit et la quantité s'il vous plait
            </div>
            <?php $form = ActiveForm::begin(['id' => 'form-menu']); ?>
            <?= $form->field($entreeStock, 'id')->textInput(['id'=>'id','type'=>'hidden','value'=>0])->label(false)->error(false) ?>
            <div class="col-md-4">
                <div class="mrg-top-0">
                    <label>Produit</label>
                    <select id="selectize-group" placeholder="Selectionnez le produit ...">
                        <option id="select" value=""></option>
                        <?php foreach ($categories as $key => $categorie): ?>
                            <optgroup label="<?= $categorie->designation ?>">
                                <?php foreach ($categorie->produits as $k => $produit): ?>    
                                    <?php if ($produit->statut==1): ?>      
                                        <option value="<?= $produit->id.'*'.$produit->designation ?>"><?= $produit->designation ?></option>
                                        <?php endif ?> >
                                    <?php endforeach ?>
                                </optgroup>
                            <?php endforeach ?>

                        </select>
                    </div>
                </div>
                <div class="col-sm-4">      
                    <?= $form->field($entreeStock, 'quantite')->textInput(['placeholder'=>'quantite','id'=>'quantite'])->label('Quantité')->error(false) ?>
                </div>
                <div class="col-sm-3">
                    <div class="mrg-top-0">
                        <label>Fournisseur</label>
                        <select id="selectize-dropdown" placeholder="Selectionnez le fournisseur ...">
                            <option id="" value=""></option>
                            <?php foreach ($fournisseurs as $key => $fournisseur): ?>
                                <option value="<?= $fournisseur->id."*".$fournisseur->nom ?>"><?= $fournisseur->nom ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-1 form-group dropdown inline-block" style="margin-top: 2.2%;">     
                    <?= Html::Button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'ass-button', 'onclick'=>'newItem();']) ?>
                </div>
<!--             <div class="col-sm-1 form-group dropdown inline-block" style="margin-top: 2.2%; display: none;">     
                <?= Html::Button('<i class="fa fa-check"></i>', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'ass-button', 'onclick'=>'addRavitaillement();']) ?>
            </div -->
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
                                    <th><div class="mrg-btm-15">Ravitaillement</div></th>
                                    <th><div class="mrg-btm-15">Produits ravitaillés</div></th>
                                    <th><div class="mrg-btm-15">Date</div></th>
                                    <th><div class="mrg-btm-15">Utilisateur</div></th>
                                    <th><div class="mrg-btm-15">Status</div></th>
                                    <th><div class="mrg-btm-15">Actions</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($entreeStocks): ?>

                                    <?php foreach ($entreeStocks as $key=>$entreeStock): ?>
                                        <tr id="entreeStock_<?= $entreeStock->id ?>">
                                            <td>
                                                <div class="checkbox mrg-left-20">
                                                    <input id="task_<?= $entreeStock->id ?>" name="task[]" type="checkbox">
                                                    <label for="task_<?= $entreeStock->id ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span>Ravitaillement # <?= ++$key ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $entreeStock->find()->where(['reference'=>$entreeStock->reference])->count(); ?> Produit(s)</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= explode(' ',$entreeStock->date_create)[0] ?> </span>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $entreeStock->createBy->username ?></span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="mrg-top-15" data-toggle="modal" data-target="#default-modal" title="" onclick="doIt('act','<?= $entreeStock->id ?>','<?= $entreeStock->statut ?>')">
                                                    <span>
                                                        <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                                                            <input id="statut_<?= $entreeStock->id ?>" type="checkbox" name="toggle5"  <?= $entreeStock->statut == 1?'checked':'' ?> value="<?= $entreeStock->statut ?>" disabled>
                                                            <label for="statut_<?= $entreeStock->id ?>"></label>
                                                        </div>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-20  font-size-18">
                                                    <a href="#" title="Modifier" onclick="modifentreestockShow('<?= $entreeStock->id."*".$entreeStock->quantite."*".str_replace("'", "\'", $entreeStock->produit->id)."*".str_replace("'", "\'", $entreeStock->fournisseur->id) ?>')" ><span class="icon-holder"><i class="ti-pencil"></i></span></a>
                                                    <a href="#" data-toggle="modal" data-target="#default-modal" title="Supprimer" onclick="doIt('supp','<?= $entreeStock->id ?>','<?= $entreeStock->statut ?>')"><span class="icon-holder"><i class="ti-trash"></i></span></a>
                                                    <a href="#" data-toggle="modal" data-target="#modal-lg" title="Détails" onclick="details('<?= $entreeStock->reference ?>')"><span class="icon-holder"><i class="ti-view-list"></i></span></a>
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
