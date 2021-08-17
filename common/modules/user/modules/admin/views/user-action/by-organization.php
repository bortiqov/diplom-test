<?php

use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
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
                                'user.first_name',
                                'user.last_name',
                                'user.email',
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
                        'user.first_name',
                        'user.last_name',
                        'user.email',
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
