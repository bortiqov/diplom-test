<?php

use common\modules\file\widgets\FileManagerModalSingle;
use common\modules\user\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\modules\user\models\VisaRequest */
/* @var $form yii\widgets\ActiveForm */

$form_name = $model->formName();

$current_language = \Yii::$app->language;
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
                        <?= $form->field($model, 'first_name')->textInput() ?>
                        <?= $form->field($model, 'last_name')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-wrapper">
                    <h3 class="panel-heading">File</h3>
                    <div class="panel-body">
                        <div class="form-group" style="margin: 0;">
                            <?= FileManagerModalSingle::widget([
                                'attribute' => "{$form_name}[file_id]",
                                'via_relation' => "file_id",
                                'model_db' => $model,
                                'form' => $form,
                                'multiple' => false,
                                'mime_type' => 'image'
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-wrapper">
                    <div class="panel-body">
                        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!$model->isNewRecord): ?>
        <?= Html::submitButton(__('Update'), ['class' => 'btn btn-success']) ?>
    <?php else: ?>
        <?= Html::submitButton(__('Save'), ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>
</div>
