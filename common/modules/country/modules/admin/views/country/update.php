<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\country\models\Country */

$this->title = 'Update Country: ' . $model->name[\Yii::$app->language];
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name[\Yii::$app->language], 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
