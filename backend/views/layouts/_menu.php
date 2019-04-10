 <?php
 use yii\helpers\Html;
 use yii\helpers\Url;
 use backend\controllers\Common;
 $menus = Common::getmenus(\Yii::$app->user->identity->id);
 //print_r($menus);exit;
 ?>              
 <div class="side-nav-inner">
    <div class="side-nav-logo">
        <a href="<?= url::to(['site/index']) ?>">
            <div class="logo logo-dark" style="background-image: url('<?= \Yii::$app->homeUrl ?>/asset/images/logo/logo.png')"></div>
            <div class="logo logo-white" style="background-image: url('asset/images/logo/logo-white.png')"></div>
        </a>
        <div class="mobile-toggle side-nav-toggle" style="background-image: url('asset/images/logo/favicon.fw.png')">
            <a href="<?= url::to(['site/index']) ?>">
                <i class="ti-arrow-circle-left"></i>
            </a>
        </div>
    </div>
    <ul class="side-nav-menu scrollable">
        <?php foreach ($menus as $key => $menu): ?>
            <?php if (explode('*',$key)[1]): ?>
                <li class="nav-item active">
                    <a class="mrg-top-30" href="<?= url::to([explode('*',$key)[1]]) ?>">
                        <span class="icon-holder">
                            <i class="ti-palette"></i>
                        </span>
                        <span class="title"><?= ucfirst(explode('*',$key)[0] ) ?></span>
                    </a>
                </li>
                <?php else: ?>

                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="javascript:void(0);">
                            <span class="icon-holder">
                                <i class="ti-package"></i>
                            </span>
                            <span class="title"><?= ucfirst(explode('*',$key)[0]) ?></span>
                            <span class="arrow">
                                <i class="ti-angle-right"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($menu as $key => $sousmenu): ?>
                                <?php if (isset(explode('*',$sousmenu)[2]) && explode('*',$sousmenu)[2]==1): ?> 
                                    <li>
                                        <?php(explode('*',$sousmenu))  ?>
                                        <a href="<?= url::to([explode('*',$sousmenu)[1]]) ?>"><?= ucfirst(explode('*',$sousmenu)[0]) ?></a>
                                    </li>     
                                <?php endif ?>
                            <?php endforeach ?>
                            
                        </ul>
                    </li>

                <?php endif ?> 

            <?php endforeach ?>      
        </ul>
    </div>