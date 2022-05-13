<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\file\models\File */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

	<div class="white-box">

		<div class="form-group">
			<?php if($model->getIsImage()): ?>
				<img src="<?= $model->getSrc('medium') ?>">
			<?php endif; ?>
		</div>

	    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'caption')->textInput() ?>

	</div>

	<div class="form-group">
	    <?= Html::submitButton(Yii::t('system', 'Save'), ['class' => 'btn btn-success']) ?>
	</div>

<?php ActiveForm::end(); ?>
