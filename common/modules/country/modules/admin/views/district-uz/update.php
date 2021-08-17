<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\country\models\District */

$this->title = 'Update District Uz: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'District Uzs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="district-uz-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
