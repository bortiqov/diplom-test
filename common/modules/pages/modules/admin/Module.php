<?php

namespace common\modules\pages\modules\admin;
use common\modules\pages\models\Pages;
use yii\filters\AccessControl;

/**
 * pages module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'common\modules\pages\modules\admin\controllers';

    public $defaultRoute = "pages";

   /* public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Pages::PERMESSION_ACCESS],
                    ],
                ],
            ],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
