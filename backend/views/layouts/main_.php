<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\widgets\Alert;
use kartik\widgets\Growl;

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8" />
    <title>DTRF</title>
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

            <!-- 
                ASIDE 
                Keep it outside of #wrapper (responsive purpose)
            -->
            <aside id="aside">
                <!--
                    Always open:
                    <li class="active alays-open">

                    LABELS:
                        <span class="label label-danger pull-right">1</span>
                        <span class="label label-default pull-right">1</span>
                        <span class="label label-warning pull-right">1</span>
                        <span class="label label-success pull-right">1</span>
                        <span class="label label-info pull-right">1</span>
                    -->
                    <nav id="sideNav"><!-- MAIN MENU -->
                        <ul class="nav nav-list">
                            <li class="active"><!-- dashboard -->
                                <a class="dashboard" href="<?= url::to(['site/index']) ?>"><!-- warning - url used by default by ajax (if eneabled) -->
                                    <i class="main-icon fa fa-dashboard"></i> <span>Tableau de bord</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-menu-arrow pull-right"></i>
                                    <i class="main-icon fa fa-database"></i> <span>Données</span>
                                </a>
                                <ul><!-- submenus -->
                                    <li><a href="<?= url::to(['fichier/create']) ?>">Charger un fichier</a></li>
                                    <li><a href="<?= url::to(['sent/index']) ?>">Liste des données</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-menu-arrow pull-right"></i>
                                    <i class="main-icon fa fa-bullhorn"></i> <span>Communiqués</span>
                                </a>
                                <ul><!-- submenus -->
                                    <li><a href="<?= url::to(['information/index']) ?>">Information</a></li>
                                    <li><a href="<?= url::to(['type-information/index']) ?>">Type information</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-menu-arrow pull-right"></i>
                                    <i class="main-icon fa fa fa-cogs"></i> <span>paramètres</span>
                                </a>
                                <ul><!-- submenus -->
                                    <li><a href="<?= url::to(['examen/index']) ?>">Examen</a></li>
                                    <li><a href="<?= url::to(['annee/index']) ?>">Annee</a></li>
                                    <li><a href="<?= url::to(['typealerte/index']) ?>">Type alerte</a></li>
                                    <li><a href="<?= url::to(['alerte/index']) ?>">Alerte</a></li>
                                </ul>
                            </li>
                        </ul>
                    </ul>

                    <ul class="nav nav-list">
                        <li>
                            <a href="<?= url::to(['site/logout'])?>">
                                <i class="main-icon fa fa-lock"></i>
                                <span class="label label-primary pull-right"></span> <span>Déconnexion</span>
                            </a>
                        </li>
                    </ul>

                </nav>

                <span id="asidebg"><!-- aside fixed background --></span>
            </aside>
            <!-- /ASIDE -->


            <!-- HEADER -->
            <header id="header">

                <!-- Mobile Button -->
                <button id="mobileMenuBtn"></button>

                <!-- Logo -->
                <span class="logo pull-left text-white text-size-100">

                    <b>DTRF Admin</b>
                    <!-- <img src="assets/images/logo_light.png" alt="admin panel" height="35" /> -->
                </span>

                <form method="get" action="page-search.html" class="search pull-left hidden-xs">
                    <input type="text" class="form-control" name="k" placeholder="Search for something..." />
                </form>

                <nav>

                    <!-- OPTIONS LIST -->
                    <ul class="nav pull-right">

                        <!-- USER OPTIONS -->
                        <li class="dropdown pull-left">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img class="user-avatar" alt="" src="assets/images/noavatar.jpg" height="34" /> 
                                <span class="user-name">
                                    <span class="hidden-xs">
                                        Isdore <i class="fa fa-angle-down"></i>
                                    </span>
                                </span>
                            </a>
                            <ul class="dropdown-menu hold-on-click">
                                <li><!-- settings -->
                                    <a href="page-user-profile.html"><i class="fa fa-cogs"></i> Paramètres</a>
                                </li>

                                <li class="divider"></li>

                                <li><!-- logout -->
                                    <a href="<?= url::to(['site/logout'])?>"><i class="fa fa-power-off"></i> Déconnexion </a>
                                </li>
                            </ul>
                        </li>
                        <!-- /USER OPTIONS -->

                    </ul>
                    <!-- /OPTIONS LIST -->

                </nav>

            </header>
            <!-- /HEADER -->


            <!-- 
                MIDDLE 
            -->
            <section id="middle">

                <div class="margin-left-10" >
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>
                    </div>

                    <div class="col-md-10 col-sm-push-1" >



                    </div>

                    <?= $content ?>
                </section>
                <!-- /MIDDLE -->

            </div>




            <!-- JAVASCRIPT FILES -->
            <script type="text/javascript">var plugin_path = 'plugins/';</script>

            <!-- PAGE LEVEL SCRIPT -->
            <script type="text/javascript">
            /* 
                Toastr Notification On Load 

                TYPE:
                    primary
                    info
                    error
                    success
                    warning

                POSITION
                    top-right
                    top-left
                    top-center
                    top-full-width
                    bottom-right
                    bottom-left
                    bottom-center
                    bottom-full-width
                    
                false = click link (example: "http://www.stepofweb.com")
                */
                _toastr("Bienvenue sur l'interface admin de la DTRF","top-right","success",false);




            /** SALES CHART
            ******************************************* **/
            loadScript(plugin_path + "chart.flot/jquery.flot.min.js", function(){
                loadScript(plugin_path + "chart.flot/jquery.flot.resize.min.js", function(){
                    loadScript(plugin_path + "chart.flot/jquery.flot.time.min.js", function(){
                        loadScript(plugin_path + "chart.flot/jquery.flot.fillbetween.min.js", function(){
                            loadScript(plugin_path + "chart.flot/jquery.flot.orderBars.min.js", function(){
                                loadScript(plugin_path + "chart.flot/jquery.flot.pie.min.js", function(){
                                    loadScript(plugin_path + "chart.flot/jquery.flot.tooltip.min.js", function(){

                                        if (jQuery("#flot-sales").length > 0) {

                                            /* DEFAULTS FLOT COLORS */
                                            var $color_border_color = "#eaeaea",        /* light gray   */
                                            $color_second       = "#6595b4";        /* blue         */


                                            var d = [
                                            [1196463600000, 0], [1196550000000, 0], [1196636400000, 0], [1196722800000, 77], [1196809200000, 3636], [1196895600000, 3575], [1196982000000, 2736], [1197068400000, 1086], [1197154800000, 676], [1197241200000, 1205], [1197327600000, 906], [1197414000000, 710], [1197500400000, 639], [1197586800000, 540], [1197673200000, 435], [1197759600000, 301], [1197846000000, 575], [1197932400000, 481], [1198018800000, 591], [1198105200000, 608], [1198191600000, 459], [1198278000000, 234], [1198364400000, 4568], [1198450800000, 686], [1198537200000, 4122], [1198623600000, 449], [1198710000000, 468], [1198796400000, 392], [1198882800000, 282], [1198969200000, 208], [1199055600000, 229], [1199142000000, 177], [1199228400000, 374], [1199314800000, 436], [1199401200000, 404], [1199487600000, 544], [1199574000000, 500], [1199660400000, 476], [1199746800000, 462], [1199833200000, 500], [1199919600000, 700], [1200006000000, 750], [1200092400000, 600], [1200178800000, 500], [1200265200000, 900], [1200351600000, 930], [1200438000000, 1200], [1200524400000, 980], [1200610800000, 950], [1200697200000, 900], [1200783600000, 1000], [1200870000000, 1050], [1200956400000, 1150], [1201042800000, 1100], [1201129200000, 1200], [1201215600000, 1300], [1201302000000, 1700], [1201388400000, 1450], [1201474800000, 1500], [1201561200000, 1510], [1201647600000, 1510], [1201734000000, 1510], [1201820400000, 1700], [1201906800000, 1800], [1201993200000, 1900], [1202079600000, 2000], [1202166000000, 2100], [1202252400000, 2200], [1202338800000, 2300], [1202425200000, 2400], [1202511600000, 2550], [1202598000000, 2600], [1202684400000, 2500], [1202770800000, 2700], [1202857200000, 2750], [1202943600000, 2800], [1203030000000, 3245], [1203116400000, 3345], [1203202800000, 3000], [1203289200000, 3200], [1203375600000, 3300], [1203462000000, 3400], [1203548400000, 3600], [1203634800000, 3700], [1203721200000, 3800], [1203807600000, 4000], [1203894000000, 4500]];

                                            for (var i = 0; i < d.length; ++i) {
                                                d[i][0] += 60 * 60 * 1000;
                                            }

                                            var options = {

                                                xaxis : {
                                                    mode : "time",
                                                    tickLength : 5
                                                },

                                                series : {
                                                    lines : {
                                                        show : true,
                                                        lineWidth : 1,
                                                        fill : true,
                                                        fillColor : {
                                                            colors : [{
                                                                opacity : 0.1
                                                            }, {
                                                                opacity : 0.15
                                                            }]
                                                        }
                                                    },
                                                   //points: { show: true },
                                                   shadowSize : 0
                                               },

                                               selection : {
                                                mode : "x"
                                            },

                                            grid : {
                                                hoverable : true,
                                                clickable : true,
                                                tickColor : $color_border_color,
                                                borderWidth : 0,
                                                borderColor : $color_border_color,
                                            },

                                            tooltip : true,

                                            tooltipOpts : {
                                                content : "Sales: %x <span class='block'>$%y</span>",
                                                dateFormat : "%y-%0m-%0d",
                                                defaultTheme : false
                                            },

                                            colors : [$color_second],

                                        };
                                        
                                        var plot = jQuery.plot(jQuery("#flot-sales"), [d], options);
                                    }

                                });
});
});
});
});
});
});
</script>

<!-- STYLESWITCHER - REMOVE -->
<script async type="text/javascript" src="assets/plugins/styleswitcher/styleswitcher_.js"></script>
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
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>