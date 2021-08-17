<?php

use common\modules\language\models\Language;
use yii\helpers\Html;
use mihaildev\ckeditor\CKEditor;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var \common\modules\country\models\Region $model */

$languages = Language::find()->active()->all();

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
                                <a href="#language-<?= $language->code ?>" data-toggle="tab"><?= mb_strtoupper($language->name) ?></a>
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
                                    <?php if (Yii::$app->controller->action->id == "update") { ?>
                                        <?= Html::submitButton(__('Update'), ['class' => 'btn btn-success']) ?>
                                    <?php } ?>
                                    <?php if (Yii::$app->controller->action->id == "create") { ?>
                                        <?= Html::submitButton(__('Save'), ['class' => 'btn btn-success']) ?>
                                    <?php } ?>
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
                    <?= $form->field($model, 'top')->dropDownList([0 => 'Не в Топ', 1 => 'Топ'], ['class' => 'form-control selectpicker', 'style' => 'width:100%', 'data-style' => "form-control"]) ?>

                    <?= $form->field($model, 'status')->dropDownList([0 => 'Неактивный', 1 => 'Активный'], ['class' => 'form-control selectpicker', 'style' => 'width:100%', 'data-style' => "form-control"]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>
