<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'user.first_name',
                                'user.last_name',
                                'user.email',
                                'user.contact_number',
                                'activities',
                            ],
                        ]); ?>

                    </div>
                </div>
            </div>
            <div class="table-responsive card-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'user.first_name',
                        'user.last_name',
                        'user.email',
                        'user.contact_number',
                        'activities',
                        [
                            'class' => \yii\grid\DataColumn::class,
                            'label' => '',
                            'format' => 'raw',
                            'value' => function($model) {
                                return Html::a('Show road', ['/user/user-action/road', 'exhibition_id' => $model->exhibition_id, 'user_id' => $model->user->id]);
                            }
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
