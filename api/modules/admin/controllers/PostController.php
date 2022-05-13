<?php

namespace api\modules\admin\controllers;

use backend\modules\admin\v1\forms\PostForm;
use common\modules\post\models\Post;
use common\modules\post\models\search\PostSearch;
use Yii;

class PostController extends \common\components\CrudController
{
    public $modelClass = Post::class;
    public $searchModel = PostSearch::class;


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    public function actionIndex()
    {
        $search = new PostSearch();

        $dataProvider = $search->search(\Yii::$app->request->queryParams);

        return $dataProvider;
    }

    public function actionCreate()
    {
        $requestParams = \Yii::$app->request->bodyParams;
        if (!$requestParams) {
            $requestParams = \Yii::$app->request->queryParams;
        }

        $postForm = new PostForm();
        $postForm->setAttributes($requestParams);

        if ($post = $postForm->save()) {
            return $post;
        }
        return $postForm;
    }

    public function actionUpdate($id)
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (!$requestParams) {
            $requestParams = \Yii::$app->request->queryParams;
        }

        $postForm = new PostForm(['id' => $id]);

        $postForm->setAttributes($requestParams);

        if ($post = $postForm->update()) {
            return $post;
        }
        return $postForm;

    }

}