<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
//use kartik\widgets\FileInput;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\profileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liste des profiles';
$this->params['breadcrumbs'][] = ['label' => 'Attribution de droits', 'url' => ['profile/droit']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script type="text/javascript">

    function doitMass(op){
        if(op == "supp"){
            var titre = "Suppression";
            var msg = "Vous êtes sur le point de supprimer ces profiles";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 1){
                var titre = "Activation";
                var msg ="Vous êtes sur le point de désactiver ces profiles";
            }else{
                var title = "Désactivation";
                var msg ="Vous êtes sur le point d'activer ces profiles";

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
            var msg = "Vous êtes sur le point de supprimer ce profile";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 2){
                var titre = "Activation";
                var msg ="Vous êtes sur le point de désactiver ce profile";
            }else if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point d'activer ce profile";
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

        var url_submit = "<?php echo Yii::$app->homeUrl ?>profile/"+action;

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

    function addprofileShow(){ 

        $('#addmenu').show();
        $('#openAdd').hide();
        $('#closeAdd').show();
        //alert(form);
    }
    function addprofileClose(){ 
        $('#closeAdd').hide();
        $('#openAdd').show();
        $('#addmenu').hide();
        //alert(form);
    }

    function addProfile(id){ 
        $('#datas').addClass('card-refresh');
        var inputs = {};

        inputs.id = $('#id').val();
        inputs.designation = $('#designation').val();
        inputs.description = $('#description').val();
        inputs.userId = <?= Yii::$app->user->identity->id ?>;
        inputs.date = <?= date('Y-m-d') ?>;

        var url = "<?php echo Yii::$app->homeUrl ?>profile/ajouter_profile";


        $.ajax({
          url: url,
          type: "POST",
          data: {
            profile: inputs,
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

    function modifprofileShow(profile) {

        var inputs = profile.split("*");
        //alert(inputs[2]);
        $('#id').val(' ');
        $('#designation').val(' ');
        $('#description').val(' ');

        $('#id').val(inputs[0]);
        $('#designation').val(inputs[1]);
        $('#description').val(inputs[2]);
        addprofileShow();


    }
</script>

<?= $this->render('../dialogue'); ?>
<div class="container-fluid">
    <div id="page" class="page-title">
        <h4>
            Liste des profiles
            <a id="openAdd" class="btn btn-info pull-right" href="#" onclick="addprofileShow()"> <i class="fa fa-plus"></i> </a>
            <a id="closeAdd"  class="btn btn-info pull-right" href="#" onclick="addprofileClose()" style="display: none;"> <i class="fa fa-close"></i> </a>
            <!-- <?= Html::a(Yii::t('app', 'Fermer <i class="fa fa-plus"></i>'), ['#'], ['class' => 'btn btn-info pull-right','style'=>'color:white;','onclick'=>'addmenu()']) ?> -->
        </h4>
    </div>
    <div class="card" id="addmenu" style="display: none;">
        <div class="card-block" id="form">
            <?php $form = ActiveForm::begin(['id' => 'form-profile']); ?>
            <?= $form->field($profile, 'id')->textInput(['id'=>'id','type'=>'hidden'])->label(false)->error(false) ?>
            <div class="col-sm-3">      
                <?= $form->field($profile, 'designation')->textInput(['placeholder'=>'designation','id'=>'designation'])->label('designation')->error(false) ?>
            </div>
            <div class="col-sm-8">      
                <?= $form->field($profile, 'description')->textInput(['placeholder'=>'Description','id'=>'description'])->label('Description')->error(false) ?>
            </div>
            <div class="col-sm-1 form-group dropdown inline-block" style="margin-top: 2.7%;">     
                <?= Html::Button('+', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'ass-button', 'onclick'=>'addProfile(0);']) ?>
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
                                    <th><div class="mrg-btm-15">designation</div></th>
                                    <th><div class="mrg-btm-15">Description</div></th>
                                    <th><div class="mrg-btm-15">Utilisateur</div></th>
                                    <th><div class="mrg-btm-15">Statut</div></th>
                                    <th><div class="mrg-btm-15">Actions</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($profiles): ?>

                                    <?php foreach ($profiles as $profile): ?>
                                        <tr id="profile_<?= $profile->id ?>">
                                            <td>
                                                <div class="checkbox mrg-left-20">
                                                    <input id="task_<?= $profile->id ?>" name="task[]" type="checkbox">
                                                    <label for="task_<?= $profile->id ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $profile->designation ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $profile->description ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <!-- <span><?= Yii::$app->homeUrl.$profile->date ?></span> -->
                                                    <span><?= $profile->user->username ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15" data-toggle="modal" data-target="#default-modal" title="" onclick="doIt('act','<?= $profile->id ?>','<?= $profile->statut ?>')">
                                                    <span>
                                                        <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 text-center">
                                                            <input id="statut_<?= $profile->id ?>" type="checkbox" name="toggle5"  <?= $profile->statut == 1?'checked':'' ?> value="<?= $profile->statut ?>" disabled >
                                                            <label for="statut_<?= $profile->id ?>"></label>
                                                        </div>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-20 text-center font-size-18">
                                                    <a href="#" title="Modifier" onclick="modifprofileShow('<?= $profile->id."*".str_replace(" ", "'", $profile->designation)."*".str_replace("'", "\'", $profile->description)."*".$profile->date."*".$profile->userId ?>')" ><span class="icon-holder"><i class="ti-pencil"></i></span></a>
                                                    <a href="#" data-toggle="modal" data-target="#default-modal" title="Supprimer" onclick="doIt('supp','<?= $profile->id ?>','<?= $profile->id ?>')"><span class="icon-holder"><i class="ti-trash"></i></span></a>
                                                    <a href="#" title="Sous profiles"><span class="icon-holder"><i class="ti-view-list"></i></span></a>
                                                    <!-- <button class="btn btn-icon btn-flat btn-rounded dropdown-toggle">
                                                        <i class="ti-more-alt"></i>
                                                    </button> -->
                                                </div>
                                            </td>
                                        </tr>  

                                    <?php  endforeach ?>

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
