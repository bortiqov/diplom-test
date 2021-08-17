<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use common\modules\language\widgets\LangsWidgets;
use kartik\daterange\DateRangePicker;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\menu\models\MenuItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Items';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="menu-items-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Menu Items', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'attribute' => 'title.' .Yii::$app->language
            ],

            //'menu_item_id',
            //'menu_id',
            //'title',
            //'url:ntext',
            //'sort',
            //'menu_item_parent_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
