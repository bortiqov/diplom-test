<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\country\models\District */

$this->title = 'Create District Uz';
$this->params['breadcrumbs'][] = ['label' => 'District Uzs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="district-uz-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
