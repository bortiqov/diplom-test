<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\category\models\Category */

$this->title = Yii::t('app', 'Update Category: {name}', [
    'name' => $model->name[Yii::$app->language],
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name[Yii::$app->language], 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
