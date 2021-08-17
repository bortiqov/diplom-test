<?php

use common\modules\language\widgets\LangsWidgets;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\Values */

$this->title = 'Update Values: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->value_id, 'url' => ['view', 'id' => $model->value_id]];
$this->params['breadcrumbs'][] = 'Update';

echo LangsWidgets::widget(['model_db' => $model,'create_url' => '/settings/settings/create/']);
?>
<div class="values-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
