<?php

use common\modules\language\widgets\LangsWidgets;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\Values */

$this->title = 'Create Values';
$this->params['breadcrumbs'][] = ['label' => 'Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo LangsWidgets::widget();
?>
<div class="values-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
