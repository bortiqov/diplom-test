<?php

/* @var $this \common\components\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container mt--8 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-header bg-transparent pb-5 pt-5">
                    <div class="btn-wrapper text-center">
                        <img src="<?=$this->getAssetUrl(\backend\assets\admin\AdminAsset::class, "img/logo.png")?>" width="170" style="filter: invert(0.4)" />
                    </div>
                </div>
                <div class="card-body px-lg-5 py-lg-4">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['role' => 'form',],
                        'fieldConfig' => [
                            'inputTemplate' => '
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-a-83"></i></span>
                                        </div>
                                        {input}
                                    </div>
                                </div>',
                            'checkboxTemplate' => '
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                                    <label class="custom-control-label" for=" customCheckLogin">
                                        <span class="text-muted">Remember me</span>
                                    </label>
                                </div>
                            '
                        ]
                    ]); ?>

                    <?= $form->field($model, 'login')->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Email'
                    ])->label(false) ?>

                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

                    <div class="text-center">
                        <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>


                </div>
            </div>
        </div>
    </div>
</div>
