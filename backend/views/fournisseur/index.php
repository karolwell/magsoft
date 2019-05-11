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

<script type="text/javascript">

    function checkAll(){

        if ($("#task").is(':checked')) {
            $("._task").prop("checked", true);
        } else {
            $("._task").prop("checked", false);
        }
        //alert(state);
    }


    function doitMass(op){
        if(op == "supp"){
            var titre = "Suppression";
            var msg = "Vous êtes sur le point de supprimer ces fournisseurs";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver ces fournisseurs";
            }else{
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer ces fournisseurs";

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
            var msg = "Vous êtes sur le point de supprimer ce fournisseur";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 2){
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer ce fournisseur";   
            }else if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver ce fournisseur";
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

        var url_submit = "<?php echo Yii::$app->homeUrl ?>fournisseur/"+action;

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
    function addclientShow(){ 

        $('#addfournisseur').show();
        $('#openAdd').hide();
        $('#closeAdd').show();
        //alert(form);
    }
    function addclientClose(){ 
        $('#closeAdd').hide();
        $('#openAdd').show();
        $('#addfournisseur').hide();
        //alert(form);
    }

    function addFournisseur(id){ 
        $('#datas').addClass('card-refresh');
        var inputs = {};

        inputs.id = $('#id').val();
        inputs.nom = $('#nom').val();
        inputs.tel = $('#tel').val();
        inputs.email = $('#email').val();
        inputs.adresse = $('#adresse').val();
        //jnputs.lien = $("#signupform-regionsid").get(0).options[0] = new Option("Chargement des regions", "-1");

        var url = "<?php echo Yii::$app->homeUrl ?>fournisseur/ajouter_fournisseur";

        $.ajax({
          url: url,
          type: "POST",
          data: {
            fournisseur: inputs,
        },
        success: function (data) {

          var datas = JSON.parse(data);

          if(datas.state=='ok'){
              $('#datas').removeClass('card-refresh');  
              location.reload(true);
              //$("#datas").load("#datas");
          }else{
              $('#datas').removeClass('card-refresh');  
              location.reload(true);
          }

      }
  });
    }

    function modiffournisseurShow(client) {
        var inputs = client.split("*");
        //alert(inputs);
        $('#id').val(inputs[0]);
        $('#nom').val(inputs[1]);
        $('#tel').val(inputs[2]);
        $('#email').val(inputs[3]);
        $('#adresse').val(inputs[4]);
        addclientShow();
    }

    function details(id){
        $('#modal-lg').addClass('card-refresh');
        $('#content').html(' ');
        $('#detail-titre').html('Les ravitaillements lié au fournisseur');

        var url = "<?php echo Yii::$app->homeUrl ?>fournisseur/details";

        $.ajax({
          url: url,
          type: "POST",
          data: {
            fournisseur: id,
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
            Liste des clients
            <a id="openAdd" class="btn btn-info pull-right" href="#" onclick="addclientShow()"> <i class="fa fa-plus"></i> </a>
            <a id="closeAdd"  class="btn btn-info pull-right" href="#" onclick="addclientClose()" style="display: none;"> <i class="fa fa-close"></i> </a>
            <!-- <?= Html::a(Yii::t('app', 'Fermer <i class="fa fa-plus"></i>'), ['#'], ['class' => 'btn btn-info pull-right','style'=>'color:white;','onclick'=>'addmenu()']) ?> -->
        </h4>
    </div>
    <div class="card" id="addfournisseur" style="display: none;">
        <div class="card-block" id="form">
            <?php $form = ActiveForm::begin(['id' => 'form-menu']); ?>
            <?= $form->field($fournisseur, 'id')->textInput(['id'=>'id','type'=>'hidden'])->label(false)->error(false) ?>
            <div class="col-sm-3">      
                <?= $form->field($fournisseur, 'nom')->textInput(['placeholder'=>'Nom','id'=>'nom'])->label('Nom')->error(false) ?>
            </div>
            <div class="col-sm-2">      
                <?= $form->field($fournisseur, 'tel')->textInput(['placeholder'=>'Tel','id'=>'tel'])->label('Tel')->error(false) ?>
            </div>
            <div class="col-sm-2">      
                <?= $form->field($fournisseur, 'email')->textInput(['placeholder'=>'Email','id'=>'email'])->label('Email')->error(false) ?>
            </div>
            <div class="col-sm-4">      
                <?= $form->field($fournisseur, 'adresse')->textInput(['placeholder'=>'Adresse','id'=>'adresse'])->label('Adresse')->error(false) ?>
            </div>
            <div class="col-sm-1 form-group dropdown inline-block" style="margin-top: 2.2%;">     
                <?= Html::Button('<i class="fa fa-check"></i>', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'ass-button', 'onclick'=>'addFournisseur(0);']) ?>
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
                                <?php if ($fournisseur): ?>

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
            </div>
        </div>
    </div>
</div>
