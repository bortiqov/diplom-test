<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\translations\models\SourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Source Messages';
$this->params['breadcrumbs'][] = $this->title;
$langs = \common\modules\langs\models\Langs::find()->all();
$sources = \common\modules\translation\models\SourceMessage::find()->all();
$s = 0;
?>

<p>
    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
</p>
<table class="table">
    <thead>
        <tr>
            <td>#</td>
            <td><?=__("Источник")?></td>
            <?php foreach ($langs as $lang):?>
                <td>
                    <?php echo $lang->name;?>
                </td>
            <?php endforeach;?>
        </tr>
    </thead>
    <tbody>
            <?php foreach ($sources as $source): $messages = $source->messages;?>
                <?php $s++;?>
                    <tr>
                        <td>
                            <?=$source->id?>
                        </td>
                        <td>
                            <?=$source->message?>
                        </td>
                        <?php foreach ($langs as $lang): ?>
                            <?php
                                $value_query = \common\modules\translation\models\Message::find()->where(['id' => $source->id])->andWhere(['language' => $lang->code]);
                                if($value_query->count() == 0){
                                    $value_lang = $source->message;
                                }else{
                                    $value_lang = $value_query->one()->translation;
                                }
                            ?>
                            <td>
                                <?php
                                echo Editable::widget([
                                    'name'=>'translation['.$lang->code.']['.$source->id.']',
                                    'asPopover' => true,
                                    'value' => $value_lang,
                                    'header' => 'Name',
                                    'size'=>'md',
                                    'options' => ['class'=>'form-control', 'placeholder'=>'Enter person name...']
                                ]);
                                ?>
                            </td>
                        <?php endforeach;?>
                    </tr>
            <?php endforeach;?>
    </tbody>
</table>
