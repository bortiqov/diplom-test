<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use dosamigos\ckeditor\CKEditor;
use dosamigos\selectize\SelectizeDropDownList;
use dosamigos\selectize\SelectizeTextInput;
use common\modules\settings\models\Settings;

/* @var $this yii\web\View */
/* @var $model common\modules\settings\models\Settings */
/* @var $form yii\widgets\ActiveForm */


$addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;

$jsdata = <<< JS
    $('#settings-input').change(function(){
        console.log($(this));
        console.log($(this).val());
        if($(this).val() > 1 && $(this).val() < 4){
            $('.field-settings-data').show();
        }else{
            $('.field-settings-data').hide();
        }
    });
    $('#settings-input').change();
JS;

$this->registerJs($jsdata);


?>

<?php $form = ActiveForm::begin(); ?>
<div class="container-fluid">

    <div class="row">
        <div class="col-xl-8">
            <div class="card shadow p-4 mt-4">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'default')->textInput(['maxlength' => true]) ?>
            </div>

        </div>
        <div class="col-xl-4">
            <div class="card shadow p-4 mt-4">
                <?= $form->field($model, 'type')->dropDownList(Settings::find()->types()) ?>

                <?= $form->field($model, 'input')->dropDownList(Settings::find()->inputs()) ?>

                <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>


                <div class="form-group">
                    <?php if (Yii::$app->controller->action->id == "update") { ?>
                        <?= Html::submitButton(__('Update'), ['class' => 'btn btn-success']) ?>
                    <?php } ?>
                    <?php if (Yii::$app->controller->action->id == "create") { ?>
                        <?= Html::submitButton(__('Save'), ['class' => 'btn btn-success']) ?>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>
