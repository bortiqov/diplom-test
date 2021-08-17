<?php

/* @var $this yii\web\View */
/* @var $model common\modules\pages\models\Pages */

$this->title = Yii::t('app','Create Pages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'languages' => $languages,
]) ?>
