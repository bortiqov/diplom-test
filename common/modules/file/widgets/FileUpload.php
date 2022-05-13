<?php

namespace common\modules\file\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\jui\InputWidget;
use common\modules\file\assets\FileUploadAsset;

/**
 * Class FileUpload
 *
 * @package common\modules\file\widgets
 */
class FileUpload extends InputWidget
{
	/**
	 * @var
	 */
	public $url;

	/**
	 * @var
	 */
	public $formId;

	/**
	 * @var string
	 */
	public $mainView = 'main';

	/**
	 * @var string
	 */
	public $uploadTemplateView = 'upload';

	/**
	 * @var string
	 */
	public $downloadTemplateView = 'download';

	/**
	 * @throws \yii\base\InvalidConfigException
	 */
	public function init()
    {
        parent::init();
        
        if(empty($this->url)) {
            throw new InvalidConfigException('"url" cannot be empty.');
        }
        if(empty($this->formId)) {
            throw new InvalidConfigException('"formId" cannot be empty.');
        }

        $this->clientOptions['url'] = $this->options['data-url'] = Url::to($this->url);
        if (!isset($this->options['multiple'])) {
            $this->options['multiple'] = true;
        }
    }

	/**
	 * @return string|void
	 */
	public function run()
    {
        echo $this->render($this->mainView);
		echo $this->render($this->uploadTemplateView);
		echo $this->render($this->downloadTemplateView);
        
        $this->registerClientScript();
    }
    
    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        $view = $this->getView();

		FileUploadAsset::register($view);

        $id = $this->formId ? : $this->options['id'];
        $this->registerClientOptions('fileupload', $id);
        $this->registerClientEvents('fileupload', $id);
    }
}
