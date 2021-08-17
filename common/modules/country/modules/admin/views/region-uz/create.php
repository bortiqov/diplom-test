<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\country\models\Region */

$this->title = 'Create Region Uz';
$this->params['breadcrumbs'][] = ['label' => 'Region Uz', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-uz-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
