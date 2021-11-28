<?php

use common\components\LatLngFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Point */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <?= $form->field($model, 'name')->textInput() ?>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'lat')->textInput() ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'lon')->textInput() ?>
                        </div>
                    </div>
                    <?= LatLngFinder::widget([
                        'model' => $model,
                        'mapWidth' => '100%',
                        'mapHeight' => 450,
                        'defaultLat' => 41.2995,
                        'defaultLng' => 69.2401,
                        'defaultZoom' => 13,
                        'enableZoomField' => false,
                        'latAttribute' => 'lat',
                        'lngAttribute' => 'lon',
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="form-group" style="margin: 0;">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $form = ActiveForm::end(); ?>