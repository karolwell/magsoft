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

$this->title = 'Liste des utilisateurs';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['profile/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script type="text/javascript">

    function doitMass(op){
        if(op == "supp"){
            var titre = "Suppression";
            var msg = "Vous êtes sur le point de supprimer ces utilisateurs";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 1){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver ces utilisateurs";
            }else{
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer ces utilisateurs";

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
            var msg = "Vous êtes sur le point de supprimer cet utilisateur";
            var action = "supprimer";
        }else if(op == "act"){
            var action = "activer_desactiver";
            if(state == 11){
                var titre = "Activation";
                var msg ="Vous êtes sur le point d'activer cet utilisateur";   
            }else if(state == 10){
                var titre = "Désactivation";
                var msg ="Vous êtes sur le point de désactiver cet utilisateur";
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

        var url_submit = "<?php echo Yii::$app->homeUrl ?>user/"+action;

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
    function adduserShow(){ 

        $('#adduser').show();
        $('#openAdd').hide();
        $('#closeAdd').show();
        //alert(form);
    }
    function adduserClose(){ 
        $('#closeAdd').hide();
        $('#openAdd').show();
        $('#adduser').hide();
        //alert(form);
    }

    function addUser(id){ 
        $('#datas').addClass('card-refresh');
        var inputs = {};

        inputs.id = $('#id').val();
        inputs.username = $('#username').val();
        inputs.telephone = $('#telephone').val();
        inputs.email = $('#email').val();
        inputs.password_confirm = $('#password_confirm').val();
        inputs.password = $('#password').val();
        inputs.profileId = $('#selectize-group').val();
        //jnputs.lien = $("#signupform-regionsid").get(0).options[0] = new Option("Chargement des regions", "-1");

        var url = "<?php echo Yii::$app->homeUrl ?>user/ajouter_utilisateur";

        $.ajax({
          url: url,
          type: "POST",
          data: {
            user: inputs,
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

    function modifuserShow(user) {
        var inputs = user.split("*");
        //alert(inputs);
        $('#id').val(inputs[0]);
        $('#username').val(inputs[1]);
        $('#telephone').val(inputs[2]);
        $('#email').val(inputs[3]);
        $('#selectize-group').val(inputs[4]);
        adduserShow();
    }
</script>

<?= $this->render('../modal'); ?>

<div class="container-fluid">
    <div id="page" class="page-title">
        <h4>
            Liste des usilisateurs
            <a id="openAdd" class="btn btn-info pull-right" href="#" onclick="adduserShow()"> <i class="fa fa-plus"></i> </a>
            <a id="closeAdd"  class="btn btn-info pull-right" href="#" onclick="adduserClose()" style="display: none;"> <i class="fa fa-close"></i> </a>
            <!-- <?= Html::a(Yii::t('app', 'Fermer <i class="fa fa-plus"></i>'), ['#'], ['class' => 'btn btn-info pull-right','style'=>'color:white;','onclick'=>'adduser()']) ?> -->
        </h4>
    </div>
    <div class="card" id="adduser" style="display: none;">
        <div class="card-block" id="form">
            <?php $form = ActiveForm::begin(['id' => 'form-menu']); ?>
            <?= $form->field($user, 'id')->textInput(['id'=>'id','type'=>'hidden'])->label(false)->error(false) ?>
            <div class="col-sm-3">      
                <?= $form->field($user, 'username')->textInput(['placeholder'=>'Nom utilisateur','id'=>'username'])->label('Nom utilisateur')->error(false) ?>
            </div>
            <div class="col-sm-3">      
                <?= $form->field($user, 'telephone')->textInput(['placeholder'=>'telephone','id'=>'telephone'])->label('telephone')->error(false) ?>
            </div>
            <div class="col-sm-3">      
                <?= $form->field($user, 'email')->textInput(['placeholder'=>'email','id'=>'email'])->label('email')->error(false) ?>
            </div>
            <div class="col-sm-3">      
                <?= $form->field($user, 'password')->textInput(['placeholder'=>'Mot de passe','id'=>'password','type'=>'password'])->label('Mot de passe')->error(false) ?>
            </div>
            <div class="col-sm-3">      
                <?= $form->field($user, 'password_confirm')->textInput(['placeholder'=>'Confirmer le mot de passe','id'=>'password_confirm','type'=>'password'])->label('Confirmer')->error(false) ?>
            </div>
            <div class="col-md-3">
                <div class="mrg-top-0">
                    <label>Profile</label>
                    <select id="selectize-group" placeholder="Selectionnez le profile ...">
                        <option id="select" value=""></option>
                        <?php foreach ($profiles as $key => $profile): ?>
                            <option value="<?= $profile->id ?>"><?= $profile->designation ?></option>
                        <?php endforeach ?>

                    </select>
                </div>
            </div>
            <div class="col-sm-1 form-group dropdown inline-block" style="margin-top: 2.2%;">     
                <?= Html::Button('<i class="fa fa-check"></i>', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'ass-button', 'onclick'=>'addUser(0);']) ?>
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
                                    <th><div class="mrg-btm-15">Nom utilisateur</div></th>
                                    <th><div class="mrg-btm-15">Telephone</div></th>
                                    <th><div class="mrg-btm-15">Email</div></th>
                                    <th><div class="mrg-btm-15">Profile</div></th>
                                    <th><div class="mrg-btm-15">status</div></th>
                                    <th><div class="mrg-btm-15">Actions</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($users): ?>

                                    <?php foreach ($users as $user): ?>
                                        <tr id="user_<?= $user->id ?>">
                                            <td>
                                                <div class="checkbox mrg-left-20">
                                                    <input id="task_<?= $user->id ?>" name="task[]" type="checkbox">
                                                    <label for="task_<?= $user->id ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $user->username ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <!-- <span><?= Yii::$app->homeUrl.$user->username ?></span> -->
                                                    <span><?= $user->telephone ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= $user->email ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15">
                                                    <span><?= (isset($user->profile->designation))? $user->profile->designation : '' ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-15" data-toggle="modal" data-target="#default-modal" title="" onclick="doIt('act','<?= $user->id ?>','<?= $user->status ?>')">
                                                    <span>
                                                        <div class="toggle-checkbox toggle-warning checkbox-inline toggle-sm mrg-top-10 mrg-left-0">
                                                            <input id="status_<?= $user->id ?>" type="checkbox" name="toggle5"  <?= $user->status == 10?'checked':'' ?> value="<?= $user->status ?>" disabled>
                                                            <label for="status_<?= $user->id ?>"></label>
                                                        </div>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mrg-top-20  font-size-18">
                                                    <a href="#" title="Modifier" onclick="modifuserShow('<?= $user->id."*".str_replace(" ", "\'", $user->username)."*".$user->telephone."*".str_replace("'", "\'", $user->email."*".$user->profileId) ?>')" ><span class="icon-holder"><i class="ti-pencil"></i></span></a>
                                                    <a href="#" data-toggle="modal" data-target="#default-modal" title="Supprimer" onclick="doIt('supp','<?= $user->id ?>','<?= $user->id ?>')"><span class="icon-holder"><i class="ti-trash"></i></span></a>
                                                    <a href="#" title="Détails"><span class="icon-holder"><i class="ti-view-list"></i></span></a>
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
