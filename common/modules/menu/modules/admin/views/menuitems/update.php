<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use common\modules\language\widgets\LangsWidgets;
use dosamigos\ckeditor\CKEditor;
use dosamigos\selectize\SelectizeDropDownList;
use dosamigos\selectize\SelectizeTextInput;
use kartik\widgets\Select2;
use kartik\editable\Editable;
use kartik\daterange\DateRangePicker;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\modules\menu\models\MenuItems */

$this->title = 'Update Menu Items: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Menu Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title[Yii::$app->language], 'url' => ['view', 'id' => $model->menu_item_id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="menu-items-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
