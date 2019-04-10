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
/* @var $searchModel backend\models\profileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attributions de droits';
//$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['menu/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Sous menus', 'url' => ['sousmenu/index']];
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['profile/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script type="text/javascript">

    function afficher_droit(profile){
        $('#droits').addClass('card-refresh');
        var url_submit = "<?php echo Yii::$app->homeUrl ?>profile/droit_profile";

        $.ajax({
            url: url_submit,
            type: "POST",
            data: { 
                id: profile,
            },
            success: function(data) {
                $('#droits').html('');
                $('#droits').removeClass('card-refresh');
                $('#droits').html(data);
            }
        });
    }

    function checkAll(){

        if ($("#task").is(':checked')) {
            $("._task").prop("checked", true);
            $("._subtask").prop("checked", true);
        } else {
            $("._task").prop("checked", false);
            $("._subtask").prop("checked", false);
        }
        //alert(state);
    }

    function checkSubtasks(el){
        if ($("#task_"+el).is(':checked')) {
            $(".subtask_"+el).prop("checked", true);
        } else {
            $(".subtask_"+el).prop("checked", false);
        }
    }

    function checkTask(el){
        if ($(".subtask_"+el).is(':checked')) {
            $("#task_"+el).prop("checked", true);
        } else {
            $("#task_"+el).prop("checked", false);
        }
    }

    function addDroit(){
        $('#default_modal_body').removeClass('card-refresh');
        var titre = "Niveau d'accès";
        var msg = "Vous êtes sur le point d'attribuer les droit sélectionnés à ce profile";
        var action = "attribution_droit";
        var profile = $('#selectize-dropdown').val();

        //datas.push($(this).val());
        var datas= '';
        $('#titre').html(titre);            
        $('#message').html(msg);  
        $('#type_operation').val(profile);        
        $('#action').val(action);
        $('._task:checked[name="tasks[]"]').each(function() {
            var task = $(this).val();
            //datas= datas + task+'*';
            //alert(task); 
            var subtasks=[];
            $('.subtask_'+task+':checked[name="subtasks[]"]').each(function() {

             var subtask = $(this).val();
                //alert(subtask);
                subtasks.push(subtask);

            });

            datas = datas + task+'*'+subtasks+'-';
        });

            //alert(datas);
            //alert(JSON.stringify(datas));
            $('#id_element').val(datas);
        }   

        function do_operation(){
            $('#default_modal_body').addClass('card-refresh');
            var action=encodeURIComponent($('#action').val());

            var url_submit = "<?php echo Yii::$app->homeUrl ?>profile/"+action;

        //var operation=encodeURIComponent($('#type_operation').val());
        var droits=$('#id_element').val();
        var profile=encodeURIComponent($('#type_operation').val());

        $.ajax({
            url: url_submit,
            type: "POST",
            data: { 
                niveaux: droits,
                id: profile,
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
</script>

<?= $this->render('../modal'); ?>
<div class="container-fluid">
    <div id="page" class="page-title">
        <h4>
            Attributions de droits
            <a id="openAdd" class="btn btn-info pull-right" href="#" onclick="addprofileShow()"style="display: none;" > <i class="fa fa-plus"></i> </a>
            <a id="closeAdd"  class="btn btn-info pull-right" href="#" onclick="addprofileClose()" > <i class="fa fa-close"></i> </a>
            <!-- <?= Html::a(Yii::t('app', 'Fermer <i class="fa fa-plus"></i>'), ['#'], ['class' => 'btn btn-info pull-right','style'=>'color:white;','onclick'=>'addmenu()']) ?> -->
        </h4>
    </div>
    <div class="card" id="addmenu" style="display:;">
        <div class="card-block" id="form">
            <?php $form = ActiveForm::begin(['id' => 'form-profile']); ?>
            <div class="col-sm-11">      
                <div class="mrg-top-0">
                    <label>Profile</label>
                    <select id="selectize-dropdown" placeholder="Selectionnez le profile ..." onchange="afficher_droit(this.value)">
                        <option id="select" value="" disabled selected></option>
                        <?php foreach ($profiles as $key => $profile): ?>
                            <option value="<?= $profile->id ?>"><?= $profile->designation ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-1 form-group dropdown inline-block" style="margin-top: 2.2%;">     
                <?= Html::Button('<i class="fa fa-check"></i>', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'ass-button', 'data-toggle'=>'modal', 'data-target'=>'#default-modal'  ,'onclick'=>'addDroit();']) ?>
            </div> 
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="row" id="droits">

    </div>
</div>
