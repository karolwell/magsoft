<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */

$this->title = 'Create Menu';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script type="text/javascript">
	function addmenu(){	
		var form = $('#form').html();
		$('#formAdd').append(form);
		//alert(form);
	}
</script>

<div class="col-md-12" style="margin-bottom: 5%;">
	<h4 class="card-title">Enrégister un menu</h4>
	<div class="card">
		<div class="portlet">
			<ul class="portlet-item navbar">
				<li class="dropdown">
					<a href="cards.html" class="btn btn-icon btn-flat btn-rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<i class="ti-more"></i>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="cards.html">
								<i class="ti-files pdd-right-10"></i>
								<span>Duplicate</span>
							</a>
						</li>
						<li>
							<a href="cards.html">
								<i class="ti-smallcap pdd-right-10"></i>
								<span>Edit</span>
							</a>
						</li>
						<li>
							<a href="cards.html">
								<i class="ti-image pdd-right-10"></i>
								<span>Add Images</span>
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0);" class="btn btn-icon btn-flat btn-rounded" data-toggle="card-refresh">
						<i class="ti-reload"></i>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" class="btn btn-icon btn-flat btn-rounded" data-toggle="card-delete">
						<i class="ti-close"></i>
					</a>
				</li>
			</ul>
		</div>

		<div class="card-block">
			<div class="row pull-left" style="margin-left: -0%;">		
				<?php $form = ActiveForm::begin(['id' => 'form-menu']); ?>
				<div id="form">	
					<div class="col-sm-3">		
						<?= $form->field($menu, 'libelle[]')->textInput(['placeholder'=>'Libelle'])->label(false)->error(false) ?>
					</div>
					<div class="col-sm-3">		
						<?= $form->field($menu, 'lien[]')->textInput(['placeholder'=>'lien'])->label(false)->error(false) ?>
					</div>
					<div class="col-sm-5">		
						<?= $form->field($menu, 'description[]')->textInput(['placeholder'=>'description'])->label(false)->error(false) ?>
					</div>
					<div class="col-sm-1 form-group dropdown inline-block">		
						<?= Html::Button(' <i class="ti-plus font-size-9"></i>', ['class' => 'btn btn-warning no-mrg-btm','data-toggle'=>'dropdown','aria-expanded'=>'false', 'name' => 'signup-button']) ?>
						<ul class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
							<li>
								<a href="#" onclick="addmenu();">Ajouter un menu</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="buttons.html#">Ajouter un sous</a>
							</li>
						</ul>
					</div>
				</div>
				<div id="formAdd"></div>
			</div>
		</div>
		<div class="col-sm-2 form-group" style="margin-left: 3%;">		
			<?= Html::submitButton('Enrégister', ['class' => 'btn btn-warning no-mrg-btm', 'name' => 'signup-button']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>

