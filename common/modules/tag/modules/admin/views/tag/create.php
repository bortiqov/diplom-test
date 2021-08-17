<?php

use common\modules\language\widgets\LangsWidgets;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\tag\models\Tag */

$this->title = 'Create Tag';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
