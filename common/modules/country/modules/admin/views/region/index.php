<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\organisation\models\search\OrganisationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Organisations';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::beginForm(['/organisation/organisation/index'], 'post'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="card shadow" style="width:100%">
            <div class="card-header">
                <?= Html::a(
                    Yii::t('app', 'Create'),
                    ['create'],
                    ['class' => 'btn btn-primary pull-right col-md-offset-1']
                ) ?>
                <?= Html::submitButton(__("Delete"), ['class' => 'btn btn-danger',]); ?>
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
                            'checkboxOptions' => function ($model, $key, $index, $widget) {
                                return ["value" => $model->id];
                            },
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
                            'value' => 'name.' . \Yii::$app->language
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['style' => 'text-align:center;min-width:220px;max-width:220px;width:220px'],
                            'template' => '{buttons}',
                            'contentOptions' => ['style' => 'min-width:220px;max-width:220px;width:220px;text-align:center'],
                            'buttons' => [
                                'buttons' => function ($url, $model) {
                                    $update = Url::to(['/country/region/update', 'id' => $model->id]);
                                    $delete = Url::to(['/country/region/delete', 'id' => $model->id]);
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
<?= Html::endForm(); ?>
