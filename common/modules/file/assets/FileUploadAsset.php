<?php

namespace common\modules\file\assets;

use yii\web\AssetBundle;

class FileUploadAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/file/assets/main';
    public $css = [
		'css/jquery.fileupload.css',
		'css/cropper.min.css',
		'css/styles.css',
    ];
    public $js = [
		"js/tmpl.min.js",
		"js/jquery.ui.widget.js",
		"js/jquery.iframe-transport.js",
		"js/jquery.fileupload.js",
		"js/load-image.all.min.js",
		"js/canvas-to-blob.min.js",
		"js/jquery.fileupload-process.js",
		"js/jquery.fileupload-image.js",
		"js/jquery.fileupload-video.js",
		"js/jquery.fileupload-audio.js",
		"js/jquery.fileupload-validate.js",
		"js/jquery.fileupload-ui.js",

		"js/cropper.min.js",
		"js/jquery-cropper.min.js",

		"js/main.js"
    ];
	public $depends = [
		'yii\web\JqueryAsset',
	];
}
