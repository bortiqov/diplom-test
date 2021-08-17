<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use dosamigos\ckeditor\CKEditor;
use dosamigos\selectize\SelectizeDropDownList;
use dosamigos\selectize\SelectizeTextInput;
use kartik\widgets\Select2;
use kartik\editable\Editable;
use kartik\daterange\DateRangePicker;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model \common\modules\translation\models\Message*/
/* @var $form yii\widgets\ActiveForm */


$addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;

?>

<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'translation')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?php if (Yii::$app->controller->action->id == "update") { ?>
            <?= Html::submitButton(__('Update'), ['class' => 'btn btn-success']) ?>
        <?php } ?>
        <?php if (Yii::$app->controller->action->id == "create") { ?>
            <?= Html::submitButton(__('Save'), ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
