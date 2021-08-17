<?php


use common\modules\settings\models\Settings;
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
/* @var $form yii\widgets\ActiveForm */


$addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;
$langs = Settings::getValues('langs');
?>

<div class="menu-items-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'menu_id')->textInput() ?>

    <ul class="nav customtab nav-tabs">
        <?php foreach ($langs as $lang): ?>
            <li class="<?= ($lang->value == Yii::$app->language) ? 'active' : '' ?>">
                <a href="#language-<?= $lang->value ?>"
                   data-toggle="tab"><?= mb_strtoupper($lang->name) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content" style="margin: 0">
        <?php
        foreach ($langs as $lang): ; ?>
            <div class="tab-pane <?= ($lang->value == Yii::$app->language) ? 'active' : '' ?>"
                 id="language-<?= $lang->value ?>">
                <div class="pt-4">
                    <?= $form->field($model, 'title[' . $lang->value . ']')->textInput() ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?= $form->field($model, 'url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'menu_item_parent_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
