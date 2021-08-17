<?php

/* @var $this yii\web\View */
/* @var $model common\modules\pages\models\Pages */
/* @var $languages \common\modules\langs\models\Langs */

$this->title = "Page:" . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');

?>

<div class="pages-update">

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
    ]) ?>

</div>
