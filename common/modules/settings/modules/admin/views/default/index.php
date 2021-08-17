<?php

use common\modules\language\widgets\LangsWidgets;

$this->title = Yii::t('app','Settings');
$types = \common\modules\settings\models\Settings::find()->types();

$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];

?>

<div class="container-fluid">
    <div class="card shadow">
        <div class="card-body">
            <?php echo LangsWidgets::widget(); ?>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow">
        <div class="card-body">
            <!-- Nav tabs -->
<!--            <div class="mt-4">
                <div class="col">
                    <?php $t = 0; foreach ($types as $key_type=>$type): $t++; ?>
                        <?php
                        if($t == 1) {
                            $class = "btn btn-primary active";
                        }else{
                            $class = "btn btn-outline-primary";
                        }
                        ?>

                        <a href="#setting-data-<?=$key_type?>" data-toggle="tab"><div class="<?=$class?>"><?=$type?></div></a>
                    <?php endforeach;?>
                </div>
            </div> -->

            <!-- Tab panes -->
            <?php $form = yii\widgets\ActiveForm::begin();?>
            <div class="tab-content">
                <div class="col">
                    <?php $t = 0; foreach ($types as $key_type=>$type): $t++; ?>
                        <?php
                        if($t == 1) {
                            $class = "active";
                        }else{
                            $class = "";
                        }
                        ?>
                        <div class="tab-pane <?=$class?>" id="setting-data-<?=$key_type?>">
                            <?php  $settings = \common\modules\settings\models\Settings::find()->type($key_type)->all(); ?>
                            <?php foreach ($settings as $setting): ?>
                                <?php echo $setting->generateForm($form); ?>
                            <?php endforeach;?>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>

            <div class="mt-1 p-2">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php yii\widgets\ActiveForm::end(); ?>
        </div>
    </div>
</div>
