<?php

use common\modules\user\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\organization\models\search\RestaurnatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
$status = [
    User::STATUS_INACTIVE => "Неактивный",
    User::STATUS_ACTIVE => "Активный",
]
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-sortable table-hover table-striped table-bordered',
        'style' => 'width: 1000px;'
    ],
    'columns' => [
        [
            'attribute' => 'id',
            'label' => 'ID',
            'headerOptions' => ['style' => 'width:80px;text-align:center'],
            'contentOptions' => ['style' => 'text-align:center']
        ],
        'contact_number',
        [
            'attribute' => 'first_name',
            'headerOptions' => ['style' => ''],
            'contentOptions' => ['style' => ''],
        ],
        [
            'attribute' => 'last_name',
            'headerOptions' => ['style' => ''],
            'contentOptions' => ['style' => ''],
        ],
        [
            'attribute' => 'email',
            'headerOptions' => ['style' => ''],
            'contentOptions' => ['style' => '']
        ],
    ],
]); ?>
<?php $this->registerJs(<<<JS
window.print();
JS
, \yii\web\View::POS_END); ?>