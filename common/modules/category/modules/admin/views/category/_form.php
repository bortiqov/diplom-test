<?php

use common\modules\langs\models\Langs;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

$languages = \common\modules\language\models\Language::find()->active()->all();

?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

<div class="container-fluid mt-4">

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <ul class="nav customtab nav-tabs">
                        <?php
                        /**
                         * @var $languages Langs[]
                         */
                        foreach ($languages as $key => $language): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $key != 0 ?: 'active' ?>" href="#language-<?= $language->code ?>"
                                   data-toggle="tab"><?= mb_strtoupper($language->name) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content" style="margin: 0">
                        <?php
                        /**
                         * @var $languages Langs[]
                         */
                        foreach ($languages as $key => $language): ?>
                            <div class="tab-pane <?= $key != 0 ?: 'active show' ?>" id="language-<?= $language->code ?>">
                                <div class="pt-4">
                                    <?= $form->field($model, 'name[' . $language->code . ']')->textInput() ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?= $model->isNewRecord ? $form->field($model, 'slug')->textInput() : '' ?>

                    <?= $form->field($model, 'parent_id')->widget(Select2::class, [
                        'data' => \common\modules\category\models\Category::getDropdownList(),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
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
