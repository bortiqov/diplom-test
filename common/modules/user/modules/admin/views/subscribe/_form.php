<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\Subscribe */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="container-fluid">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-wrapper">
                    <div class="panel-body">
                        <?= $form->field($model, 'email')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (Yii::$app->controller->action->id == "update") { ?>
        <?= Html::submitButton(__('Update'), ['class' => 'btn btn-success']) ?>
    <?php } ?>
    <?php if (Yii::$app->controller->action->id == "create") { ?>
        <?= Html::submitButton(__('Save'), ['class' => 'btn btn-success']) ?>
    <?php } ?>
    <?php ActiveForm::end(); ?>
</div>