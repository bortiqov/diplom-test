<?php

use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\user\models\UserActionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Actions';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row">
        <div class="card shadow" style="width:100%">
            <div class="card-header">
                <div class="row items-align-center">
                    <div class="col">

                        <?= ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'class' => \yii\grid\DataColumn::class,
                                    'attribute' => 'exhibition_id',
                                    'label' => 'Exhibition',
                                    'filter' => \common\modules\exebition\models\Exebition::getDropDownList(),
                                    'value' => function($model) {
                                        return $model->exhibition->name[\Yii::$app->language];
                                    }
                                ],
                                [
                                    'class' => \yii\grid\DataColumn::class,
                                    'label' => 'Organization',
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        return Html::a($model->getOrganization($model->get_params)->one()->name[\Yii::$app->language], ['/user/user-action/by-organization', 'id' => $model->get_params]);
                                    }
                                ],
                                [
                                    'class' => \yii\grid\DataColumn::class,
                                    'label' => 'Activities',
                                    'value' => function($model) {
                                        return $model->getActivities($model->exhibition_id, $model->get_params)->count();
                                    }
                                ],
                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>

                    </div>
                </div>
            </div>
            <div class="table-responsive card-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'class' => \yii\grid\DataColumn::class,
                            'attribute' => 'exhibition_id',
                            'label' => 'Exhibition',
                            'filter' => \common\modules\exebition\models\Exebition::getDropDownList(),
                            'value' => function($model) {
                                return $model->exhibition->name[\Yii::$app->language];
                            }
                        ],
                        [
                            'class' => \yii\grid\DataColumn::class,
                            'label' => 'Organization',
                            'format' => 'raw',
                            'value' => function($model) {
                                return Html::a($model->getOrganization($model->get_params)->one()->name[\Yii::$app->language], ['/user/user-action/by-organization', 'id' => $model->get_params]);
                            }
                        ],
                        [
                            'class' => \yii\grid\DataColumn::class,
                            'label' => 'Activities',
                            'value' => function($model) {
                                return \common\modules\user\models\UserAction::getActivities($model->exhibition_id, $model->get_params)->count();
                            }
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
