<?php

use common\modules\file\widgets\FileManagerModalSingle;
use common\modules\post\models\Post;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\post\models\post */
/* @var $form yii\widgets\ActiveForm */
$languages = \common\modules\language\models\Language::find()->active()->all();
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
                            <li class="<?= $key != 0 ?: 'active' ?>">
                                <a href="#language-<?= $language->code ?>"
                                   data-toggle="tab"><?= mb_strtoupper($language->name) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content" style="margin: 0">
                        <?php
                        /**
                         * @var $languages
                         */
                        foreach ($languages as $key => $language): ?>
                            <div class="tab-pane <?= $key != 0 ?: 'active in' ?>" id="language-<?= $language->code ?>">
                                <div class="pt-4">
                                    <?= $form->field($model, 'title[' . $language->code . ']')->textInput() ?>
                                    <?= $form->field($model, 'description[' . $language->code . ']')->widget(CKEditor::class) ?>
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
                    <h3 class="panel-heading">Main Photo</h3>
                    <div class="panel-body">
                        <div class="form-group" style="margin: 0;">
                            <?= FileManagerModalSingle::widget([
                                'attribute' => "Post[photo]",
                                'via_relation' => "photo",
                                'model_db' => $model,
                                'form' => $form,
                                'multiple' => false,
                                'mime_type' => 'image'
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <?= $form->field($model, 'anons')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'status',
                        [
                            'options' => [
                                'class' => 'form-group form-group-default input-group'
                            ],
                            'template' => '<label class="inline" for="PostForm-status">' . __("Published") . '</label>
                                       <label class="custom-toggle ml-2">{input}<span class="custom-toggle-slider rounded-circle"></span></label>',
                            'labelOptions' => ['class' => 'inline']
                        ])->checkbox([
                        'data-init-plugin' => 'switchery',
                        'data-color' => 'primary'
                    ], false);
                    ?>
                    <?= $form->field($model, 'type')
                        ->dropDownList([
                            Post::TYPE_DEFAULT => __("Макола"),
                            Post::TYPE_VEBINAR => __("Vebinar"),
                        ]) ?>
                    <?= $form->field($model, 'published_at',
                        [
                            'options' => [
                                'class' => 'form-group form-group-default input-group',
                            ],
                            'template' => '
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        {input}{error}
                    </div>',
                        ])->textInput([
                        'class' => 'form-control datepicker',
                        "placeholder" => "Select date",
                        "value" => date("m/d/Y", $model->isNewRecord ? time() : $model->published_at)
                    ], false);
                    ?>
                    <div class="panel-body">
                        <div>
                            <label style='<?= $model->getErrors('filesdata') ? "color: red;" : "" ?>'
                                   class="poster-label control-label"
                                   for="post-filesdata"><?= __("Photos") ?></label>
                            <?= \common\modules\file\widgets\FileManagerModal::widget([
                                'model_db' => $model,
                                'form' => $form,
                                'attribute' => 'Post[filesdata]',
                                'id' => 'post_filesdata',
                                'relation_name' => 'files',
                                'via_relation_name' => 'postImgs',
                                'multiple' => true,
                                'mime_type' => 'image'
                            ]); ?>
                        </div>
                    </div>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

    </div>
</div>
<?php ActiveForm::end(); ?>
