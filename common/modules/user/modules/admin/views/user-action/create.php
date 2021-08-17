<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\UserAction */

$this->title = 'Create User Action';
$this->params['breadcrumbs'][] = ['label' => 'User Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-action-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
