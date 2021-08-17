<?php

use common\modules\language\widgets\LangsWidgets;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\menu\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Menus');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">
    <div class="row">
        <div class="card shadow" style="width:100%">
            <div class="card-header">
                <div class="row items-align-center">
                    <div class="col text-right">
                        <?= Html::a(Yii::t('app', 'Create Menu'), ['create'],
                            ['class' => 'btn btn-primary pull-right col-md-offset-1']) ?>
                    </div>
                </div>
            </div>
            <div class="table-responsive card-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => '{items}{summary}{pager}',
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'width:8%'],
                        ],
                        [
                            'attribute' => 'title',
                            'content' => function($data){
                                return "<a href='".\yii\helpers\Url::to(['/menu/menu/update','id' => $data->menu_id])."'>".$data->title[Yii::$app->language]."</a>";
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => Yii::t('app', 'Actions'),
                            'headerOptions' => ['style' => 'text-align:center'],
                            'template' => '{buttons}',
                            'contentOptions' => [
                                'style' => 'min-width:150px;max-width:150px;width:150px',
                                'class' => 'v-align-middle'
                            ],
                            'buttons' => [
                                'buttons' => function ($url, $model) {
                                    $controller = Yii::$app->controller->id;
                                    $deleteText = __("Are you sure you want to delete this item?");
                                    $code = <<<BUTTONS
                                                <div class="btn-group flex-center">
                                                    <a href="/{$controller}/{$controller}/update/?id={$model->menu_id}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                    <a href="/{$controller}/{$controller}/delete?id={$model->menu_id}" data-method="post" data-postID="{$model->menu_id}" data-postType="{$controller}" class="btn btn-danger postRemove" data-confirm = '{$deleteText}' data-method = 'post'>
                                                       <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
BUTTONS;
                                    return $code;
                                }

                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
