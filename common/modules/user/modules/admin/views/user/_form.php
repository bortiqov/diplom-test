<?php

use common\modules\file\widgets\FileManagerModalSingle;
use common\modules\user\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\User */
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
                    <?= $form->field($model, 'email')->textInput() ?>
                    <?= $form->field($model, 'first_name')->textInput() ?>
                    <?= $form->field($model, 'last_name')->textInput() ?>
                    <?= $form->field($model, 'phone')->textInput() ?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-wrapper">
                <div class="panel-body">
                    <?= $form->field($model, 'password')->textInput(['type' => 'password']) ?>
                    <?= $form->field($model, 'password_confirm')->textInput(['type' => 'password']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-wrapper">
                <h3 class="panel-heading">Изображение</h3>
                <div class="panel-body">
                    <div class="form-group" style="margin: 0;">
                        <?= FileManagerModalSingle::widget([
                            'attribute' => "{$form_name}[image_id]",
                            'via_relation' => "image_id",
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
                    <?= $form->field($model, 'status')->dropDownList([
                        User::STATUS_ACTIVE => 'Активный',
                        User::STATUS_INACTIVE => 'Неактивный'
                    ], ['class' => 'form-control selectpicker', 'style' => 'width:100%', 'data-style' => "form-control"]) ?>

                    <?php $model->organizationIds = $model->organizations; ?>
                    <?php $organizations = \common\modules\organization\models\Organization::find()->all(); ?>
                    <?= $form->field($model, 'organizationIds')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($organizations, 'id', function ($item) use ($current_language) {
                            return $item['title'][$current_language];
                        }),
                        'options' => ['placeholder' => 'Выберите организации...', 'multiple' => true],
                    ])->label('Организации') ?>

                    <?= $form->field($model, 'role')->dropDownList(User::getRoles(), [
                        'class' => 'form-control selectpicker',
                        'style' => 'width:100%', 'data-style' => "form-control",
                        'prompt' => __('Select user role'),
                        'value' => !empty(User::getUserRole($model->id)) ? User::getUserRole($model->id) : 0
                    ]) ?>
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
