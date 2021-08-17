<?php

use common\modules\language\widgets\LangsWidgets;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;
use kartik\switchinput\SwitchInput;
use common\modules\post\models\Post;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\settings\models\ValuesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Values';
$this->params['breadcrumbs'][] = $this->title;

echo LangsWidgets::widget();

?>
<div class="values-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Values', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'attribute' => 'value'
            ],

            //'value_id',
            //'type',
            //'value:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
