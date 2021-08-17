<?php

use common\modules\language\models\Language;
use kartik\select2\Select2;
use yii\helpers\Html;
use mihaildev\ckeditor\CKEditor;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var \common\modules\country\models\Region $model */

$languages = \common\modules\langs\models\Langs::find()->active()->all();

?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

<div class="container-fluid mt-4">

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <ul class="nav customtab nav-tabs">
                        <?php
                        /**
                         * @var $languages \common\modules\langs\models\Langs[]
                         */
                        foreach ($languages as $key => $language): ?>
                            <li class="<?= $key != 0 ?: 'active' ?>">
                                <a href="#language-<?= $language->code ?>"
                                   data-toggle="tab"><?= mb_strtoupper($language->name) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content" style="margin: 0">
                        <?php
                        /**
                         * @var $languages \common\modules\langs\models\Langs[]
                         */
                        foreach ($languages as $key => $language): ?>
                            <div class="tab-pane <?= $key != 0 ?: 'active in' ?>" id="language-<?= $language->code ?>">
                                <div class="pt-4">
                                    <?= $form->field($model, 'name[' . $language->code . ']')->textInput() ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?= $form->field($model, 'region_id')->widget(Select2::classname(), [
                        'data' => \common\modules\country\models\Region::getDropDownList(),
                        'options' => ['placeholder' => 'Select a region ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <?= $form->field($model, 'top')->dropDownList([0 => 'Не в Топ', 1 => 'Топ'], ['class' => 'form-control selectpicker', 'style' => 'width:100%', 'data-style' => "form-control"]) ?>

                    <?= $form->field($model, 'status')->dropDownList([0 => 'Неактивный', 1 => 'Активный'], ['class' => 'form-control selectpicker', 'style' => 'width:100%', 'data-style' => "form-control"]) ?>

                    <?= Html::submitButton(__('Save'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

