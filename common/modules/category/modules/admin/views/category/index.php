<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\product\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$language = \Yii::$app->language;

$this->title = 'Category';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="white-box">
    <?= Html::beginForm(['/category/category'], 'post'); ?>
    <?= Html::submitButton('Удалить', ['class' => 'btn btn-danger',]); ?>
    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success pull-right']) ?>

    <div class="clearfix"></div>
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'tableOptions' => [
            'class' => 'table table-sortable table-hover table-striped table-bordered',
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions' => ['style' => 'width:50px;text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
            ],
            [
                'attribute' => 'id',
                'label' => 'ID',
                'headerOptions' => ['style' => 'width:80px;text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']
            ],
            [
                'attribute' => 'name',
                'headerOptions' => ['style' => ''],
                'contentOptions' => ['style' => ''],
                'value' => function($model){
                    return @$model->name[Yii::$app->language];
                }
            ],
            [
                'attribute' => 'slug',
                'headerOptions' => ['style' => 'width:80px;text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']
            ],
            [
                'attribute' => 'icon',
                'headerOptions' => ['style' => 'width:80px;text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']
            ],
            [
                'attribute' => 'created_at',
                'headerOptions' => ['style' => 'width:80px;text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']
            ],
            [
                'attribute' => 'parent',
                'headerOptions' => ['style' => 'width:80px;text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
                'value' => function ($model){
                    return @$model->parent->name[Yii::$app->language];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'text-align:center;min-width:120px;max-width:220px;width:220px'],
                'template' => '{buttons}',
                'contentOptions' => ['style' => 'min-width:120px;max-width:220px;width:220px;text-align:center'],
                'buttons' => [
                    'buttons' => function ($url, $model) {
                        $update = Url::to(['/category/category/update', 'id' => $model->id]);
                        $delete = Url::to(['/category/category/delete', 'id' => $model->id]);
                        $code = <<<BUTTONS
                            <div>
                                <a href="{$update}" data-pjax="0" class="btn btn-info btn-icon">
                                    <div>
                                        <i class="fa fa-edit"></i>
                                    </div>
                                </a>
                                <a href="{$delete}"  data-confirm="Are you sure?" data-method="post" class="btn btn-danger btn-icon">
                                    <div>
                                        <i class="fa fa-trash"></i>
                                    </div>
                                </a>
                            </div>
BUTTONS;
                        return $code;
                    }

                ],
            ]
        ],
    ]); ?>
    <?= Html::endForm(); ?>
</div>
