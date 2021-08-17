<?php

use common\modules\user\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\organization\models\search\RestaurnatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subscribe';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col text-right">
            <?= Html::a(Yii::t('app', 'Create Post'), ['create'],
                ['class' => 'btn btn-success pull-right col-md-offset-1']) ?>
        </div>
        <div class="card shadow" style="width: 100%">

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
                            'attribute' => 'email',
                            'headerOptions' => ['style' => ''],
                            'contentOptions' => ['style' => ''],
                        ],
                        [
                            'attribute' => 'created_at',
                            'headerOptions' => ['style' => ''],
                            'contentOptions' => ['style' => ''],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['style' => 'text-align:center;min-width:160px;max-width:160px;width:150px'],
                            'template' => '{buttons}',
                            'contentOptions' => ['style' => 'min-width:160px;max-width:150px;width:160px;text-align:center'],
                            'buttons' => [
                                'buttons' => function ($url, $model) {
                                    $update = Url::to(['/user/subscribe/update', 'id' => $model->id]);
                                    $delete = Url::to(['/user/subscribe/delete', 'id' => $model->id]);
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
            </div>
        </div>
    </div>
</div>