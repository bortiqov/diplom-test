<?php

namespace common\modules\file\modules\admin\controllers;

use common\modules\user\models\User;
use Yii;
use common\modules\file\models\File;
use common\modules\file\models\FileSearch;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-file' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		if(!Yii::$app->user->can(User::STATUS_ACTIVE)){
			$searchModel->user_id = Yii::$app->user->getId();
		}

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single File model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new File();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);

		$model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('main', 'The requested page does not exist.'));
    }

	/**
	 * @return array|bool
	 */
	public function actionUpload()
	{
        Yii::$app->response->format = Response::FORMAT_JSON;
        $keys = array_keys($_FILES);
        if(!count($keys)){ return false; }
        $output = [];
		foreach ($keys as $key) {
            $files = UploadedFile::getInstancesByName( $key );
            if(count($files)) {
				foreach($files as $file) {
					$model = new File();
					$model->file_data = $file;
					if($model->save()) {
						$output['files'][] = [
							'id'           => $model->id,
							'name'         => Html::encode($model->title),
							'size'         => $model->size,
							'url'          => $model->src,
							'thumbnailUrl' => $model->getSrc('thumb'),
							'updateUrl' => Url::to(['/file/file/update', 'id' => $model->id]),
							'isImage'      => $model->getIsImage(),
							'deleteUrl'    => Url::to(['/file/file/delete', 'id' => $model->id]),
							'deleteType'   => 'POST',
							'sizes'        => $model->getImageInfo()
						];
					}
					else{
                        var_dump($model);
                        die();
                    }
				};
			}
		};
		if(count($output) > 0)
			return $output;

		throw new ServerErrorHttpException(Yii::t('main', 'The requested page does not exist.'));
	}

    /**
     * @param $id
     * @return array|bool
     * @throws ForbiddenHttpException
     * @throws ServerErrorHttpException
     */
    public function actionUploadSecure($id)
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$keys = array_keys($_FILES);
		if(!count($keys)){ return false; }
		$output = [];
		foreach ($keys as $key) {
			$files = UploadedFile::getInstancesByName( $key );
			if(count($files)) {
				foreach($files as $file) {
					$model = new File();
					$model->file_data = $file;
					$model->file_secure = 1;
					$model->user_id = $id;
					if($model->save()) {
						$output['files'][] = [
							'id'           => $model->id,
							'name'         => Html::encode($model->title),
							'size'         => $model->size,
							'url'          => $model->src,
							'thumbnailUrl' => $model->getSrc('thumb'),
							'updateUrl' => Url::to(['/file/file/update', 'id' => $model->id]),
							'isImage'      => $model->getIsImage(),
							'deleteUrl'    => Url::to(['/file/file/delete', 'id' => $model->id]),
							'deleteType'   => 'POST',
							'sizes'        => $model->getImageInfo()
						];
					}
				};
			}
		};
		if(count($output) > 0)
			return $output;

		throw new ServerErrorHttpException(Yii::t('main', 'The requested page does not exist.'));
	}

	/**
	 * @return array|bool
	 */
	public function actionDetail($file_id)
	{
		$model = $this->findModel($file_id);

		Yii::$app->response->format = Response::FORMAT_JSON;
		return [
			'title'       => Html::encode($model->title),
			'caption'     => Html::encode($model->caption),
			'description' => Html::encode($model->description),
			'size'        => $model->readableSize,
			'mime_type'   => $model->mime_type,
			'isImage'     => $model->getIsImage(),
			'url' 		  => $model->getSrc(),
			'thumb_url'   => $model->getSrc('small'),
			'date_create' => Yii::$app->formatter->asDate($model->date_create, 'dd.MM.yy HH:mm'),
			'resolutions' => $model->getImageInfo()
		];
	}

	/**
	 * @param $file_id
	 *
	 * @return array
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionUpdateDetail($file_id)
	{
		$model = $this->findModel($file_id);


		Yii::$app->response->format = Response::FORMAT_JSON;
		$this->enableCsrfValidation = false;
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return [
				'success' => true,
				'title'   => Html::encode($model->title),
			];
		}
		return [
			'success' => false,
			'errors'  => $model->getErrors()
		];
	}

	/**
	 * @param $id
	 *
	 * @return array
	 * @throws \Exception
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionDeleteFile($file_id)
	{
		$model = $this->findModel($file_id);

		Yii::$app->response->format = Response::FORMAT_JSON;
		if($model->delete()){
			return [
				'success' => true,
			];
		}
		return [
			'success' => false,
			'errors'  => $model->getErrors()
		];
	}

	public function checkAccess($action = "", $model = "", $param = [])
	{
		if( $action == "create" ) {
			if(!$model->canCreate()){
				throw new ForbiddenHttpException( 'You can not ' . $action . ' file.' );
			}
		}
		if( $action == "update" ) {
			if(!$model->canUpdate()){
				throw new ForbiddenHttpException( 'You can not ' . $action . ' file.' );
			}
		}
		if($action == "delete"){
			if(!$model->canDelete()){
				throw new ForbiddenHttpException('You can not ' . $action . ' file.');
			}
		}
		if($action == "view"){
			if(!$model->canView()){
				throw new ForbiddenHttpException('You can not ' . $action . ' file.');
			}
		}
	}
}
