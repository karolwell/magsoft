<?php
use backend\assetS\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\widgets\Alert;
//use kartik\widgets\Growl;


/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);

//$this->title = 'Admin';

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8" />
    <meta name="keywords" content="HTML5,CSS3,Template" />
    <meta name="description" content="" /> 

    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?= Yii::$app->homeUrl ?>/asset/images/logo/favicon.png">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->


    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>
<?php $this->beginBody() ?>

<div id="apps" class="app is-collapsed">
    <div class="layout">
        <!-- Side Nav START -->
        <div class="side-nav">
            <?= $this->render('_menu') ?>
        </div>
        <!-- Side Nav END -->

        <!-- Page Container START -->
        <div class="page-container">
            <!-- Header START -->
            <div class="header navbar">
                <?= $this->render('_header') ?>   
            </div>
            <!-- Header END -->

            <!-- Side Panel START -->
            <div class="side-panel">
                <?= $this->render('_side') ?>   
            </div>
            <!-- Side Panel END -->

            <!-- theme configurator START -->
            <div class="theme-configurator">
                <?= $this->render('_theme');?>
            </div>
            <!-- theme configurator END -->

            <!-- Theme Toggle Button START -->
            <button class="theme-toggle btn btn-rounded btn-icon">
                <i class="ti-palette"></i>
            </button>
            <!-- Theme Toggle Button END -->

            <!-- Content Wrapper START -->
            <div class="main-content">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <br/>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
            <!-- Content Wrapper END -->

            <!-- Footer START -->
            <footer class="content-footer" style="background-color:#f6aa55; color:white; z-index: 500; position: ; width: 100%; margin-top: -0%;">
                <div class="footer">
                    <div class="copyright">
                        <span>Copyright © 2019 <b class="text-dark">MagSoft.</b> Tout droit réservé.</span>
                        <span class="go-right">
                            <a href="index.html" class="text-white mrg-right-15"> <b>CFK CONCEPT</b></a>
                            <!-- <a href="index.html" class="text-gray">Privacy &amp; Policy</a> -->
                        </span>
                    </div>
                </div>
            </footer>
            <!-- Footer END -->

        </div>
        <!-- Page Container END -->

    </div>
</div>

<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>
<script type="text/javascript">
  function filter (phrase, _id){
    var words = phrase.value.toLowerCase().split(" ");
    var table = document.getElementById(_id);
    var ele;
    for (var r = 1; r < table.rows.length; r++){
      ele = table.rows[r].innerHTML.replace(/<[^>]+>/g,"");
      var displayStyle = 'none';
      for (var i = 0; i < words.length; i++) {
        if (ele.toLowerCase().indexOf(words[i])>=0)
          displayStyle = '';
      else {
          displayStyle = 'none';
          break;
      }
  }
  table.rows[r].style.display = displayStyle;
}
}
</script>