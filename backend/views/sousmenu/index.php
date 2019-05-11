<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use backend\models\Menu;
use backend\models\SousMenu;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des menus';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['menu/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script type="text/javascript">

    function doitMass(op){
        if(op == "supp"){
            var titre = "Suppression";
            var msg = "Vous êtes sur le point de supprimer ces sous menus";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 1){
                var titre = "Activation";
                var msg ="Vous êtes sur le point de désactiver ces sous menus";
            }else{
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point d'activer ces sous menus";

            }
        }else if(op == "vis"){
            var action = "visibiliter";
            var titre = "Visibilité";
            if(state == 1){
                var msg ="Vous êtes sur le point de rendre visible ces sous menus";
            }else{
                var msg ="Vous êtes sur le point de rendre invisible ces sous menus";

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
            var msg = "Vous êtes sur le point de supprimer ce sous menu";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 2){
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer ce sous menu";
            }else if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver ce sous menu";  
            }
        }else if(op == "vis"){
            var action = "visibiliter";
            var titre = "Visibilité";
            if(state == 1){
                var msg ="Vous êtes sur le point de rendre invisible ce sous menu";
            }else{
                var msg ="Vous êtes sur le point de rendre visible ce sous menu";

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

        var url_submit = "<?php echo Yii::$app->homeUrl ?>sousmenu/"+action;

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
    function addmenuShow(){ 

        $('#addmenu').show();
        $('#openAdd').hide();
        $('#closeAdd').show();
        //alert(form);
    }
    function addmenuClose(){ 

        $('#closeAdd').hide();
        $('#openAdd').show();
        $('#addmenu').hide();
        //alert(form);
    }

    function addMenu(id){ 
        $('#datas').addClass('card-refresh');
        var inputs = {};

        inputs.id = $('#id').val();
        inputs.libelle = $('#libelle').val();
        inputs.lien = $('#selectize-group').val();
        inputs.description = $('#description').val();
        inputs.menuId = $('#selectize-dropdown').val();

        var url = "<?php echo Yii::$app->homeUrl ?>sousmenu/ajouter_sousmenu";


        $.ajax({
          url: url,
          type: "POST",
          data: {
            sousmenu: inputs,
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

    function modifmenuShow(sousmenu) {
        var inputs = sousmenu.split("*");
        //alert(inputs);
        $('#id').val(inputs[0]);
        $('#libelle').val(inputs[1]);
        $('#selectize-group').val(inputs[2]);
        $('#description').val(inputs[3]);
        $('#selectize-dropdown').val(inputs[4]);
        addmenuShow();

    }


    function details(id){
        $('#modal-lg').addClass('card-refresh');
        $('#content').html(' ');
        $('#detail-titre').html('Détails');

        var url = "<?php echo Yii::$app->homeUrl ?>sousmenu/details";

        $.ajax({
          url: url,
          type: "POST",
          data: {
            sousmenu: id,
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
            Liste des sous menus
            <a id="openAdd" class="btn btn-info pull-right" href="#" onclick="addmenuShow()"> <i class="fa fa-plus"></i> </a>
            <a id="closeAdd"  class="btn btn-info pull-right" href="#" onclick="addmenuClose()" style="display: none;"> <i class="fa fa-close"></i> </a>
            <!-- <?= Html::a(Yii::t('app', 'Fermer <i class="fa fa-plus"></i>'), ['#'], ['class' => 'btn btn-info pull-right','style'=>'color:white;','onclick'=>'addmenu()']) ?> -->
        </h4>
    </div>
    <div class="card" id="addmenu" style="display: none;">
        <div class="card-block" id="form">
            <?php $form = ActiveForm::begin(['id' => 'form-menu']); ?>
            <?= $form->field($sousmenu, 'id')->textInput(['id'=>'id','type'=>'hidden'])->label(false)->error(false) ?>
            <div class="col-sm-2">      
                <?= $form->field($sousmenu, 'libelle')->textInput(['placeholder'=>'Libelle','id'=>'libelle'])->label('Libelle')->error(false) ?>
            </div>
            <div class="col-md-2">
                <div class="mrg-top-0">
                    <label>Menu</label>
                    <select id="selectize-dropdown" placeholder="Selectionnez le menu ...">
                        <option id="select" value="" disabled selected></option>
                        <?php foreach ($menus as $key => $menu): ?>
                                    <option value="<?= $menu->id ?>"><?= $menu->libelle ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mrg-top-0">
                    <label>Lien</label>
                    <select id="selectize-group" placeholder="Selectionnez le lien ...">
                        <option id="select" value=""></option>
                        <?php foreach ($allActions as $key => $actions): ?>
                            <optgroup label="<?= $key ?>">
                                <?php foreach ($actions as $key => $action): ?>
                                    <option value="<?= $key ?>"><?= $action ?></option>
                                <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>

                    </select>
                </div>
            </div>
            <div class="col-sm-5">      
                <?= $form->field($sousmenu, 'description')->textInput(['placeholder'=>'Description','id'=>'description'])->label('Description')->error(false) ?>
            </div>
            <div class="col-sm-1 form-group dropdown inline-block" style="margin-top: 2.7%;">     
                <?= Html::Button('<i class="fa fa-check"></i>', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'ass-button', 'onclick'=>'addMenu(0);']) ?>
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
                                    <th><div class="mrg-btm-15">Menu</div></th>
                                    <th>
                                        <div class="checkbox mrg-left-20">
                                            <input id="task" name="task" type="checkbox">
                                            <label for="task"></label>
                                        </div>
                                    </th>
                                    <th><div class="mrg-btm-15">Libelle</div></th>
                                    <th><div class="mrg-btm-15">Lien</div></th>
                                    <th><div class="mrg-btm-15">Description</div></th>
                                    <th><div class="mrg-btm-15">Visibilité</div></th>
                                    <th><div class="mrg-btm-15">Statut</div></th>
                                    <th><div class="mrg-btm-15">Actions</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($sousmenus): ?>

                                    <?php foreach ($sousmenus as $sousmenu): ?>

                                        <tr>
                                            <td ><?= $sousmenu->menu->libelle ?></td>
                                            <td>
                                                <div class="checkbox mrg-left-20">
                                                    <input id="task_<?= $sousmenu->id ?>" name="task[]" type="checkbox">
                                                    <label for="task_<?= $sousmenu->id ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $sousmenu->libelle ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                   <!--  <span><?= Yii::$app->homeUrl.$sousmenu->lien ?></span> -->
                                                   <span><?= $sousmenu->lien ?></span>
                                               </div>
                                           </td>
                                           <td>
                                            <div class="mrg-top-15">
                                                <span><?= $sousmenu->description ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mrg-top-15" data-toggle="modal" data-target="#default-modal" title="" onclick="doIt('vis','<?= $sousmenu->id ?>','<?= $sousmenu->visible ?>')">
                                                <span>
                                                    <div class="toggle-checkbox toggle-primary checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                                                        <input id="statut_<?= $sousmenu->id ?>" type="checkbox" name="toggle5"  <?= $sousmenu->visible == 1?'checked':'' ?> value="<?= $sousmenu->statut ?>" disabled>
                                                        <label for="statut_<?= $sousmenu->id ?>"></label>
                                                    </div>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mrg-top-15" data-toggle="modal" data-target="#default-modal" title="" onclick="doIt('act','<?= $sousmenu->id ?>','<?= $sousmenu->statut ?>')">
                                                <span>
                                                    <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                                                        <input id="statut_<?= $sousmenu->id ?>" type="checkbox" name="toggle5"  <?= $sousmenu->statut == 1?'checked':'' ?> value="<?= $sousmenu->statut ?>" disabled>
                                                        <label for="statut_<?= $sousmenu->id ?>"></label>
                                                    </div>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mrg-top-20 text-center font-size-18">
                                                <a href="#" title="Modifier" onclick="modifmenuShow('<?= $sousmenu->id."*".str_replace("'", "\'", $sousmenu->libelle)."*".$sousmenu->lien."*".str_replace("'", "\'", $sousmenu->description)."*".$sousmenu->menuId ?>')" ><span class="icon-holder"><i class="ti-pencil"></i></span></a>
                                                <a href="#" data-toggle="modal" data-target="#default-modal" onclick="doIt('supp','<?= $sousmenu->id ?>','<?= $sousmenu->statut ?>')" title="Supprimer"><span class="icon-holder"><i class="ti-trash"></i></span></a>
                                                <a href="#" data-toggle="modal" data-target="#modal-lg"  title="Détails" onclick="details('<?= $sousmenu->id ?>')" ><span class="icon-holder"><i class="ti-view-list"></i></span></a>
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
