<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\user\models\UserActionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Actions';
$this->params['breadcrumbs'][] = $this->title;
?>

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

<?php $this->registerJs(<<<JS
window.print();
JS
    , \yii\web\View::POS_END); ?>