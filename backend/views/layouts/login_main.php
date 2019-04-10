<?php
use backend\assets\AppAsset_login;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\widgets\Alert;
use kartik\widgets\Growl;

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset_login::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8" />
    <title>MagSoft</title>
    <meta name="keywords" content="HTML5,CSS3,Template" />
    <meta name="description" content="" /> 

    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->


   <?= Html::csrfMetaTags() ?>
   <title><?= Html::encode($this->title) ?></title>
   <?php $this->head() ?>

</head>
<?php $this->beginBody() ?>



<!-- WRAPPER -->
<div id="wrapper" class="clearfix">

            <!-- /HEADER -->



            <!-- MIDDLE -->
            <section id="middle">

                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>

                    <div class="col-md-12 col-sm-push-" >

                        <?= Alert::widget() ?>

                    </div>

                    <?= $content ?>
                </section>
                <!-- /MIDDLE -->

            </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>