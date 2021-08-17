<?php

namespace common\modules\file\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class FilemanagerAsset extends AssetBundle
{
	public $sourcePath = '@common/modules/file/assets/main';

    public $js = [
        "js/plugin.js"
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'dosamigos\ckeditor\CKEditorAsset',
        'dosamigos\ckeditor\CKEditorWidgetAsset'
    ];
}


