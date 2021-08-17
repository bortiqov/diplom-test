<?php

namespace common\modules\translation\modules\admin\controllers;

use common\modules\language\models\Language;
use common\modules\translation\models\SourceMessage;
use Yii;
use yii\i18n\DbMessageSource;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class TranslationController
 *
 * @package backend\controllers
 */
class TranslationController extends Controller
{
	/**
	 * @return string
	 */
	public function actionIndex()
    {
		$searchModel = new SourceMessage(['scenario' => 'search']);

//		$this->checkAccess('view', $searchModel);

		return $this->render('index', [
			'dataProvider' => $searchModel->search(Yii::$app->request->get()),
			'searchModel'  => $searchModel
		]);
    }

	/**
	 * @param bool $id
	 *
	 * @return null|string
	 */
	public function actionTranslate($id = false)
	{
		$model = $this->findModel($id);

//		$this->checkAccess('create', $model);
//		$this->checkAccess('update', $model);

		$message = SourceMessage::findOne($id);
		$langs   = Language::find()->active()->all();
		if($data = Yii::$app->request->post('translation')) {
			if ($message->addTranslations($data)) {
				foreach ($langs as $lang => $name)
					Yii::$app->cache->offsetUnset([DbMessageSource::class, 'app', $lang]);
			}
			return null;
		}
		$data = [];
		foreach ($langs as $lang) {
			$data[$lang->code] = '';
		}
		if ($message) {
			foreach($message->messages as $translation) {
				$data[$translation->language] = $translation->translation;
			}
		}
		return $this->renderPartial('translate', ['messages' => $data, 'model' => $message]);
	}

	/**
	 * @param $id
	 *
	 * @return \yii\web\Response
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);

//		$this->checkAccess('delete', $model);

		$model->delete();

		return $this->redirect(['index']);
	}

	/**
	 * @param $id
	 *
	 * @return \common\modules\translation\models\SourceMessage|null
	 * @throws \yii\web\NotFoundHttpException
	 */
	protected function findModel($id)
	{
		if (($model = SourceMessage::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	/**
	 * @param string $action
	 * @param string $model
	 * @param array  $param
	 *
	 * @throws \yii\web\ForbiddenHttpException
	 */
//	public function checkAccess( $action = "", $model = "", $param = [])
//	{
//		if( $action == "create" ) {
//			if(!$model->canCreate()){
//				throw new ForbiddenHttpException( 'You can not ' . $action . ' language.' );
//			}
//		}
//		if( $action == "update" ) {
//			if(!$model->canUpdate()){
//				throw new ForbiddenHttpException( 'You can not ' . $action . ' language.' );
//			}
//		}
//		if($action == "delete"){
//			if(!$model->canDelete()){
//				throw new ForbiddenHttpException('You can not ' . $action . ' language.');
//			}
//		}
//		if($action == "view"){
//			if(!$model->canView()){
//				throw new ForbiddenHttpException('You can not ' . $action . ' language.');
//			}
//		}
//	}
}
