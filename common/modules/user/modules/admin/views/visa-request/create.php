<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\VisaRequest */

$this->title = 'Create Visa Request';
$this->params['breadcrumbs'][] = ['label' => 'Visa Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visa-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
