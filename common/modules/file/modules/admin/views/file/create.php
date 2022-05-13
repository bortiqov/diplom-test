<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\file\models\File */

$this->title = Yii::t('system', 'Create File');
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
