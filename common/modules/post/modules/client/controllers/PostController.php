<?php


namespace common\modules\post\modules\client\controllers;


use common\modules\post\models\Post;
use common\modules\post\models\search\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('@common/modules/post/modules/client/views/post/index',[
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionShow($id)
    {

        $model = $this->findModel($id);

        $model->updateCounters(['viewed' => 1]);

        return $this->render('@common/modules/post/modules/client/views/post/show', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Post|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}