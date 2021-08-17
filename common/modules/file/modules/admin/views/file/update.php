<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\file\models\File */

$this->title = Yii::t('system', 'Update File');
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('system', 'Update File');
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
