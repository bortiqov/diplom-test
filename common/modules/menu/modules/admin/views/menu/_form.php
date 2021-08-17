<?php

use common\modules\settings\models\Settings;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\menu\models\Menu */
/* @var $form yii\widgets\ActiveForm */
$addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;
$langs = \common\modules\language\models\Language::find()->active()->all();
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-xl-4">
            <div class="card shadow p-4">
                <?php if(!$model->isNewRecord):?>
                    <div class="card-header"><h3><?=Yii::t('app','Item')?></h3></div>
                    <div class="panel-body">
                        <div class="menu-items-form">

                            <?php $form = ActiveForm::begin(['id' => 'menu-form-item','options' => ['data-pjax' => true]]); ?>

                            <div class="panel panel-default">
                                <ul class="nav customtab nav-tabs">
                                    <?php foreach ($langs as $lang): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($lang->code == Yii::$app->language) ? 'active' : '' ?>" href="#languages-<?= $lang->code ?>" data-toggle="tab"><?= mb_strtoupper($lang->code) ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="tab-content" style="margin: 0">
                                    <?php
                                    foreach ($langs as $lang): ?>
                                        <div class="tab-pane fade <?= ($lang->code == Yii::$app->language) ? 'active show' : '' ?>" style="opacity: 1" id="languages-<?= $lang->code ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-wrapper">
                                                    <div class="panel-body">
                                                        <?= $form->field($menuItem, 'title[' . $lang->code . ']')->textInput() ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <?= $form->field($menuItem, 'url')->textInput(['maxlength' => true]) ?>

                            <?php  echo $form->field($menuItem, 'icon')->textInput(['maxlength' => true]); ?>

                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>

                        </div>

                    </div>
                <?php endif;?>
            </div>
            <div class="card shadow mt-4 p-4">
                <div class="card-header"><h3><?=Yii::t('app','Menu')?></h3></div>
                <div class="panel-body">
                    <div class="menu-form">
                        <?php $form = ActiveForm::begin(['id' => 'menu-form','options' => ['data-pjax' => true]]); ?>
                        <div class="panel panel-default">
                            <ul class="nav customtab nav-tabs">
                                <?php foreach ($langs as $lang): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($lang->code == Yii::$app->language) ? 'active' : '' ?>" href="#language-<?= $lang->code ?>" data-toggle="tab"><?= mb_strtoupper($lang->code) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="tab-content" style="margin: 0">
                                <?php
                                foreach ($langs as $key => $lang): ?>
                                    <div class="tab-pane fade <?= ($lang->code == Yii::$app->language) ? "active show" : '' ?>" style="opacity: 1" id="language-<?= $lang->code ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-wrapper">
                                                <div class="panel-body">
                                                    <?= $form->field($model, 'title[' . $lang->code . ']')->textInput() ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'type')->dropDownList($model::find()->types()) ?>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card shadow p-4">
                <div class="panel-heading"><?=Yii::t('app','All items')?></div>
                <div class="panel-body">
                    <?php
                    if(!$model->isNewRecord):
                        $menu = new \common\modules\menu\components\MenuAdmin(['alias' => $model->alias]);
                    endif;
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>

