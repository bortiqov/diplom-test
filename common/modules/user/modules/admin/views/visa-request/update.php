<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\VisaRequest */

$this->title = 'Update Visa Request: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Visa Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="visa-request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
