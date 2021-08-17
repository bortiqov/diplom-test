<?php

use common\modules\language\widgets\LangsWidgets;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\settings\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="container-fluid">

    <div class="container">
        <div class="card shadow" style="width: 100%;">
            <div class="card-header">
                <div class="container align-items-center">
                    <div class="col">
                        <?php echo LangsWidgets::widget(); ?>
                    </div>
                    <div class="col text-right">
                        <?= Html::a('Create Settings', ['create'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'title'
                        ],

                        //'setting_id',
                        //'title',
                        //'description:ntext',
                        //'slug',
                        //'type',
                        //'input',
                        //'default',
                        //'sort',
                        //'lang_hash',
                        //'lang',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
