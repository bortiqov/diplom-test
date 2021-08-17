<?php

//use common\modules\language\widgets\LangsWidgets;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\tag\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .nav.nav-tabs {
        border-bottom: 0px !important;
    }
</style>
<div class="row">
    <div class="col-md-9">
    <div class="col-md-3">
        <?= Html::a('Create tag', ['create'],
            ['class' => 'btn btn-primary pull-right col-md-offset-1']) ?>
    </div>
</div>

<div class="tag-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'lang',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
