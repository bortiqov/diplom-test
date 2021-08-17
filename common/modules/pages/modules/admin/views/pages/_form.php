<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\modules\pages\models\Pages */
/* @var $form yii\widgets\ActiveForm */

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
                         * @var $languages
                         */
                        foreach ($languages as $key => $language): ?>
                            <li>
                                <a class="nav-link <?= $key != 0 ?: 'active' ?>" href="#language-<?= $language->code ?>"
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
                            <div class="tab-pane <?= $key != 0 ?: 'active in' ?>"
                                 id="language-<?= $language->code ?>">
                                <div class="pt-4">
                                    <?= $form->field($model, 'title[' . $language->code . ']')->textInput() ?>
                                    <?= $form->field($model, 'subtitle[' . $language->code . ']')->textInput() ?>
                                    <?= $form->field($model, 'description[' . $language->code . ']')->widget(CKEditor::className(), [
                                        'options' => ['rows' => 6],
                                    ]) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'status')->dropDownList([
                        \common\modules\pages\models\Pages::STATUS_ACTIVE => 'Активный',
                        \common\modules\pages\models\Pages::STATUS_INACTIVE => 'Неактивный'
                    ], ['class' => 'form-control selectpicker', 'style' => 'width:100%', 'data-style' => "form-control"]) ?>

                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>