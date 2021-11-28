<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Route */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'position')->textInput() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'group_number')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="form-group">
                    <?= $form->field($model, 'point_id')->dropDownList(
                        \common\models\Route::getPointList(),
                        ['prompt' => 'Select Route']
                    )->label('Points') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'service_id')->dropDownList(
                        \common\models\Route::getServiceList(),
                        ['prompt' => 'Select Route']
                    )->label('Services') ?>
                </div>
                <div class="form-group" style="margin: 0;">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $form = ActiveForm::end(); ?>
