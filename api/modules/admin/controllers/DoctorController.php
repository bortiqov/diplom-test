<?php

namespace api\modules\admin\controllers;

use api\models\form\UserCreateForm;
use api\models\form\UserUpdateForm;
use backend\modules\admin\v1\forms\PostForm;
use common\models\Doctor;
use common\models\search\DoctorSearch;
use common\models\Service;
use common\models\ServiceSearch;
use common\modules\post\models\Post;
use common\modules\post\models\search\PostSearch;
use Yii;

class DoctorController extends \common\components\CrudController
{
    public $modelClass = Doctor::class;
    public $searchModel = DoctorSearch::class;


    public function actionCreate()
    {
        $requestParams = \Yii::$app->getRequest()->getBodyParams();
        if (!$requestParams) {
            $requestParams = \Yii::$app->getRequest()->getQueryParams();
        }

        $form = new UserCreateForm();
        $form->setAttributes($requestParams);
        if ($user = $form->save()) {
            return $user;
        }
        Yii::$app->response->setStatusCode(400);
        return $form->errors;
    }


    public function actionUpdate($id)
    {
        $requestParams = \Yii::$app->getRequest()->getBodyParams();
        if (!$requestParams) {
            $requestParams = \Yii::$app->getRequest()->getQueryParams();
        }

        $form = new UserUpdateForm([
            'id' => $id
        ]);
        $form->setAttributes($requestParams);
        if ($user = $form->save()) {
            return $user;
        }
        Yii::$app->response->setStatusCode(400);
        return $form->errors;
    }
}