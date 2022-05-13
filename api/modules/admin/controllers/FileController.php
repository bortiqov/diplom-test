<?php

namespace api\modules\admin\controllers;

use common\components\ApiController;
use common\components\CrudController;
use common\modules\file\models\File;
use common\modules\file\models\FileSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class FileController extends CrudController
{
    public $modelClass = File::class;
    public $searchModel = FileSearch::class;

    public function actionUpload()
    {
        if (!\Yii::$app->request->isPost) {
            throw new MethodNotAllowedHttpException();
        }
        $file_ids = [];
        $transaction = \Yii::$app->db->beginTransaction();
        $imagesFile = \yii\web\UploadedFile::getInstancesByName('files');

        if (!(sizeof($imagesFile) > 0)) {
            throw new BadRequestHttpException(__('File too large, or you could not have an access to upload!'));
        }

        foreach ($imagesFile as $index => $imageFile) {
            if ($imageFile instanceof UploadedFile) {
                $file = new File();
                $file->file_data = $imageFile;
                $file->user_id = \Yii::$app->user->id;
                if (!$file->save()) {
                    $transaction->rollBack();
                    return $file;
                }
                $file_ids[] = $file->id;
            }
        }

        $transaction->commit();

        return new ActiveDataProvider([
            'query' => File::find()->andWhere(['id' => $file_ids])
        ]);
    }
}