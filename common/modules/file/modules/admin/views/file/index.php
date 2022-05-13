<?php

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\modules\file\widgets\FileUploadInline;

$this->title = Yii::t('system', 'Files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">
	<?php Pjax::begin([
		'timeout' => false,
		'id' => 'files-pjax'
	]) ?>
		<?php $form = ActiveForm::begin(); ?>
			<div class="white-box">
				<?= FileUploadInline::widget([
					'model' => $dataProvider,
					'url' => ['file/upload'],
					'formId' => $form->id,
					'clientOptions' => [
						'autoUpload' => true,
						'previewCanvas' => false,
						'previewCrop' => true,
						'previewMaxHeight' => 150,
						'previewMaxWidth' => 150,
						'prependFiles' => true
					],
					'clientEvents' => [
						'stop' => "function (e) {
			                $.pjax.reload({container: '#files-pjax'});
					    }",
					]
				]);?>
			</div>

		<?php ActiveForm::end(); ?>
	<?php Pjax::end()?>
</div>