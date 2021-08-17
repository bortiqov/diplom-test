<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\pages\models\Pages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-view">



    <p>
        <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $model->page_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->page_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'page_id',
            'title',
            'subtitle',
            'description:ntext',
            'content:ntext',
            'slug',
            'template',
            'sort',
            'date_update',
            'date_create',
            'date_publish',
            'status',
            'lang_hash',
            'lang',
            'user_id',
        ],
    ]) ?>

</div>
