<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package uzbekkonsert
 */

namespace backend\assets\admin;


use yii\web\AssetBundle;

class AdminAsset extends AssetBundle {

    public $sourcePath = '@backend/assets/admin';

    public $css = [
        'argon/css/argon-dashboard.min.css',
        'argon/js/plugins/nucleo/css/nucleo.css',
        'argon/js/plugins/@fortawesome/fontawesome-free/css/all.min.css',
        'argon/js/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        'argon/plugins/switchery/css/switchery.min.css',
    	'argon/plugins/jquery-nestable/jquery.nestable.min.css',
        'css/main.css',
        'css/iziModal.min.css',
    ];

    public $js = [
//        'argon/js/plugins/jquery/dist/jquery.min.js',
//        'argon/js/plugins/chart.js/dist/Chart.min.js',
//        'argon/js/plugins/chart.js/dist/Chart.extension.js',
//        'argon/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js',

        'argon/js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        'argon/js/argon.min.js',
    	'argon/plugins/jquery-nestable/jquery.nestable.min.js',
        'argon/js/argon-dashboard.js',
        "argon/plugins/switchery/js/switchery.min.js",
        'js/iziModal.min.js',

    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];


}
