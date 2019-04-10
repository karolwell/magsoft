<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset_login extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web'; 
    //public $css = ['css/site.css'];
    public $css = [
        'asset/css/style.css',
        //'asset/vendors/bootstrap/dist/css/bootstrap.css',
        'asset/css/ei-icon.css',
        'asset/css/font-awesome.min.css',
    ];
    public $js = [
        'asset/js/vendor.js',
        'asset/vendors/bower-jvectormap/jquery-jvectormap-1.2.2.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function get(){
        return "expression";
    }
}
