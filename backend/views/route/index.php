<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RouteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Routes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="card shadow" style="width:100%">
            <div class="card-header">
                <div class="row items-align-center">
                    <div class="col text-right">
                        <?= Html::a(
                            __("Create Point"),
                            ['create'],
                            ['class' => 'btn btn-primary pull-right col-md-offset-1']
                        ) ?>
                    </div>
                </div>
            </div>
            <div class="table-responsive card-body">
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
                            'attribute' => 'position',
                            'headerOptions' => ['style' => ''],
                            'contentOptions' => ['style' => ''],
                            'value' => 'position'
                        ],
                        [
                            'attribute' => 'group_number',
                            'headerOptions' => ['style' => ''],
                            'contentOptions' => ['style' => ''],
                            'value' => 'group_number'
                        ],
                        [
                            'attribute' => 'point_id',
                            'headerOptions' => ['style' => ''],
                            'contentOptions' => ['style' => ''],
                            'value' => function($model){
                                return $model->point->name;
                            }
                        ],
                        [
                            'attribute' => 'service_id',
                            'headerOptions' => ['style' => ''],
                            'contentOptions' => ['style' => ''],
                            'value' => function($model){
                                return $model->point->name;
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['style' => 'text-align:center;min-width:220px;max-width:220px;width:220px'],
                            'template' => '{buttons}',
                            'contentOptions' => ['style' => 'min-width:220px;max-width:220px;width:220px;text-align:center'],
                            'buttons' => [
                                'buttons' => function ($url, $model) {
                                    $update = Url::to(['/route/update', 'id' => $model->id]);
                                    $delete = Url::to(['/route/delete', 'id' => $model->id]);
                                    $code = <<<BUTTONS
                            <div>
                                <a href="{$update}" data-pjax="0" class="btn btn-primary btn-icon">
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
            </div>
        </div>
    </div>
</div>
