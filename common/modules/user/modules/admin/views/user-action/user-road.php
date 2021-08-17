<?php

use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\user\models\UserActionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Actions Road';
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
                        'created_at:datetime',
                        [
                            'class' => \yii\grid\DataColumn::class,
                            'label' => 'Activity',
                            'format' => 'raw',
                            'value' => function($model) {

                                if ($model->controller == 'exhibition') {

                                    switch ($model->action) {
                                        case 'view':
                                            return "Visited to outsite hall";
                                        case 'pavilions':
                                            return "Visited to inside hall";
                                        case 'pavilion':
                                            return "Visited to pavilion " . \common\modules\pavilion\models\Pavilion::findOne($model->get_params['id'])->name;
                                        case 'stands':
                                            return "Visited to stands page";
                                        case 'organization':
                                            return "Visited to stand " . \common\modules\organisation\models\Organisation::findOne($model->get_params['organization_id'])->name[\Yii::$app->language];
                                        case 'download':
                                            $file = \common\modules\file\models\File::findOne([$model->get_params['file_id']]);
                                            return "Visitor downloaded " . \common\modules\organisation\models\Organisation::findOne($model->get_params['organization_id'])->name[\Yii::$app->language] . "'s this file " . Html::a('File', $file->getIsImage() ? $file->getSrc('medium') : $file->getSrc());
                                        case 'chat':
                                            return "Visited own private chats page";
                                        case 'seen':
                                            return "Got all messages";
                                        case 'vote':
                                            return "Visited to I vote page";
                                        case 'vote-save':
                                            return "Visitor voted " . \common\modules\organisation\models\Organisation::findOne($model->get_params['organization_id'])->name[\Yii::$app->language];
                                        case 'conferences':
                                        case 'conference':
                                            return "Visited to conferences page";

                                    }
                                }
                                if ($model->controller == 'site') {

                                    switch ($model->action) {
                                        case 'index':
                                            return "Visited to main page";
                                        case 'enter':
                                            return "Visitor entered via world-expo.uz link";
                                        case 'contact':
                                            return "Visited to contacts page";
                                        case 'confirm':
                                            return "Visitor confirmed email";
                                        case 'logout':
                                            return "Visitor logged out";
                                        case 'error':
                                            return "Error showed";

                                    }
                                }

                                if ($model->controller == 'chat') {

                                    switch ($model->action) {
                                        case 'add-public':
                                            return "Sent public message to " . \common\modules\organisation\models\Organisation::findOne($model->post_params['PublicChat']['organization_id'])->name[\Yii::$app->language];
                                        case 'add-private':
                                            return "Sent private message to " . \common\modules\organisation\models\Organisation::findOne($model->post_params['PrivateChat']['organization_id'])->name[\Yii::$app->language];

                                    }
                                }
                                return $model->controller . '/' . $model->action;

                            }
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
