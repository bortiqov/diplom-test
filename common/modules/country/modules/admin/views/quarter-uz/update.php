<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\country\models\Quarter */

$this->title = 'Update Quarter Uz: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quarter Uzs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quarter-uz-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
