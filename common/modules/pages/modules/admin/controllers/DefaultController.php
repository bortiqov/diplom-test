<?php

namespace common\modules\pages\modules\admin\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `pages` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
