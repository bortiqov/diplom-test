<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package uzbekkonsert
 */

namespace backend\assets\admin;


use yii\web\AssetBundle;

class ThetaAdminAsset extends AssetBundle {

    public $sourcePath = '@backend/assets/admin';

    public $css = [
        'theta/plugins/switchery/switchery.min.css',
        'theta/plugins/morris/morris.css',
        'theta/plugins/datepicker/datepicker.min.css',
        'theta/css/bootstrap.min.css',
        'theta/css/icons.css',
        'theta/css/flag-icon.min.css',
        'theta/css/style.css',
        'css/iziModal.min.css',
    ];

    public $js = [
//        'theta/js/jquery.min.js',
        'theta/js/popper.min.js',
        'theta/js/bootstrap.min.js',
        'theta/js/modernizr.min.js',
        'theta/js/detect.js',
        'theta/js/jquery.slimscroll.js',
        'theta/js/vertical-menu.js',
        'theta/plugins/switchery/switchery.min.js',
        'theta/plugins/morris/morris.min.js',
        'theta/plugins/raphael/raphael-min.js',
        'theta/plugins/peity/jquery.peity.min.js',
        'theta/js/custom/custom-dashboard-analytics.js',
        'theta/js/core.js',
        'js/iziModal.min.js',

    ];

    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
//        'yii\bootstrap\BootstrapPluginAsset',
    ];


}
