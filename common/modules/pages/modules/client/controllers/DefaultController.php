<?php

namespace common\modules\pages\modules\client\controllers;

use Yii;
use common\modules\pages\models\Pages;
use yii\web\Controller;

/**
 * Default controller for the `pages` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionView($slug)
    {
        $model_query = Pages::find()->slug($slug);

        if($model_query->count() == 0){
            throw new \yii\web\NotFoundHttpException(Yii::t('main','Page not created or not found'));
        }

        $model = $model_query->one();
//        $model->viewsUp();
        return $this->render('pc/view', [
            'model' => $model,
            'slug' => $slug
        ]);
    }
    public function actionShort($id = null){
        $model = Pages::findOne($id);
        if($model){
            Yii::$app->controller->redirect($model->singleLink);
            return;
        }
        throw new \yii\web\NotFoundHttpException(__("Page not found"));
    }
    public function actionPrint($slug)
    {
        $model_query = Pages::find()->slug($slug);

        if($model_query->count() == 0){
            throw new \yii\web\NotFoundHttpException(__("Page not created or not found"));
        }

        $model = $model_query->one();
        $this->layout = 'print_layout';
        return $this->render('pc/print', [
            'model' => $model,
            'slug' => $slug
        ]);
    }
}
