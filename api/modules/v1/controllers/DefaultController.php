<?php

namespace api\modules\v1\controllers;

use common\components\ApiController;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ErrorAction;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends ApiController
{

    /**
     * Renders the index view for the module
     * @return array
     */
    public function actionIndex()
    {
//        var_dump('salom');
//        die();
        return [
            "status" => "ok",
            "message" => "Welcome to Servan API version 1"
        ];
    }

    /**
     * Clear Cache (for development)
     */
    public function actionClearCache()
    {
        Yii::$app->cache->flush();
    }

    public function actionError() {
        return [
            'status' => 'error',
            'message' => Yii::$app->getErrorHandler()->exception->getMessage()
        ];
    }

}
