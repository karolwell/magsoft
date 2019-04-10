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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web'; 
    //public $css = ['css/site.css'];
    public $css = [
        //'asset/css/style.css',
        'asset/vendors/bootstrap/dist/css/bootstrap.css',
        'asset/vendors/datatables/media/css/jquery.dataTables.css',
        'asset/vendors/PACE/themes/blue/pace-theme-minimal.css',
        'asset/vendors/perfect-scrollbar/css/perfect-scrollbar.min.css',
        'asset/vendors/bower-jvectormap/jquery-jvectormap-1.2.2.css',
        'asset/vendors/selectize/dist/css/selectize.default.css',
        'asset/vendors/nvd3/build/nv.d3.min.css',
        'asset/vendors/summernote/dist/summernote.css',
        'asset/css/ei-icon.css',
        'asset/css/themify-icons.css',
        'asset/css/font-awesome.min.css',
        'asset/css/animate.min.css',
        'asset/css/app.css',
        //'css/site.css'
    ];
    public $js = [
        'asset/js/vendor.js',
        'asset/vendors/bower-jvectormap/jquery-jvectormap-1.2.2.min.js',
        'asset/js/maps/jquery-jvectormap-us-aea.js',
        'asset/vendors/d3/d3.min.js',
        'asset/vendors/nvd3/build/nv.d3.min.js',
        'asset/vendors/jquery.sparkline/index.js',
        'asset/vendors/chart.js/dist/Chart.min.js',
        'asset/js/app.min.js',
        'asset/js/dashboard/dashboard.js',
        'asset/js/charts/chartjs.js',
        'asset/vendors/datatables/media/js/jquery.dataTables.js',
        'asset/js/table/data-table.js',
        'asset/vendors/selectize/dist/js/standalone/selectize.min.js',
        'asset/vendors/moment/min/moment.min.js',
        'asset/vendors/bootstrap-daterangepicker/daterangepicker.js',
        'asset/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
        'asset/vendors/ootstrap-timepicker/js/bootstrap-timepicker.js',
        'asset/vendors/summernote/dist/summernote.min.js',
        'asset/js/forms/form-elements.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function get(){
        return "expression";
    }
}
