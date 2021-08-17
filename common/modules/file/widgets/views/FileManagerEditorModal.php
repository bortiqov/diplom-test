<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\sortinput\SortableInput;
use common\modules\file\widgets\FileUpload;

$accept = '';

if($mime_type && in_array($mime_type, $allowed_types)){
	$accept = $mime_type . '/*';
} else {
	$accept = implode('/*,', $allowed_types);
}

?>

<div id="filemanager-<?= $widget->id ?>" class="filemanager-container">

	<div class="filemanager-modal modal fade" id="filemanager-modal-<?= $widget->id ?>">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<?php $form = ActiveForm::begin(); ?>
				<div class="modal-header">
					<button type="button" data-dismiss="modal"><span>&times;</span></button>
					<label class="filemanager-upload-btn">
						<span><?= Yii::t('system', 'Добавить новый') ?></span>
						<?= Html::hiddenInput('filemanager-input-' . $widget->id) . Html::fileInput('filemanager-input-' . $widget->id, '', ['multiple' => true, 'accept' => $accept]); ?>
					</label>
					<h1><?= Yii::t('system', 'Библиотека файлов') ?></h1>
				</div>
				<div class="modal-body">
					<div class="modal-files">
						<div class="modal-files-inner">

							<?php Pjax::begin([
								'timeout' => false,
								'id' => 'files-pjax-modal-' . $widget->id,
								'enablePushState' => false
							]) ?>
								<?= FileUpload::widget([
									'model' => $model,
									'url' => [$widget->upload_url],
									'formId' => $form->id,
									'clientOptions' => [
										'autoUpload' => true,
										'prependFiles' => true,
										'filesContainer' => "#filemanager-modal-{$widget->id} .filemanager-files"
									],
									'clientEvents' => [
										'stop' => "function (e) {
											$.pjax.reload({container: '#files-pjax-modal-{$widget->id}', timeout: false});
										}",
										'fail' => "function (e) {
											alert('error')
										}"
									]
								]);?>
							<?php Pjax::end()?>
						</div>
					</div>
					<div class="modal-sidebar ">
						<div class="filemanager-item-detail-block" data-id="">
							<h2><?= Yii::t('system', 'Параметры файла') ?></h2>
							<span class="filemanager-item-saved"><?= Yii::t('system', 'Сохранено') ?></span>

							<div class="filemanager-item-info">
								<div class="thumbnail">
									<img src="" width="50px" height="50px">
								</div>
								<div class="details">
									<div class="file-mime_type">
										Тип файла: <span></span>
									</div>
									<div class="file-date_create">
										Загружен: <span></span>
									</div>
									<div class="file-size">
										Размер файла: <span></span>
									</div>
									<div class="file-resolution">
										Размеры: <span></span>
									</div>
								</div>
							</div>

							<div class="filemanager-item-settings">
								<label class="file-url">
									<span><?= Yii::t('system', 'URL') ?></span>
									<input type="text" value="http://clean.loc/uploads/3m/m_QW6sMkmKmSyfKbHMlVagBvLxdHR8hL.jpg" readonly>
								</label>
								<label class="file-title">
									<span><?= Yii::t('system', 'Заголовок') ?></span>
									<input type="text" value="">
								</label>
								<label class="file-caption">
									<span><?= Yii::t('system', 'Подпись') ?></span>
									<textarea rows="3"></textarea>
								</label>
								<label class="file-description">
									<span><?= Yii::t('system', 'Описание') ?></span>
									<textarea rows="3"></textarea>
								</label>
								<div class="text-right">
									<button><?= Yii::t('system', 'Сохранить') ?></button>
								</div>

								<h2 style="margin-top: 15px;"><?= Yii::t('system', 'Настройки отображения файла') ?></h2>

								<label class="file-append-link file-select">
									<span><?= Yii::t('main', 'Ссылка') ?></span>
									<select>
										<option value="none" selected="">Нет</option>
										<option value="file">Медиафайл</option>
										<option value="custom">Произвольный URL</option>
									</select>
									<input class="hidden" type="text" value="">
								</label>
								<label class="file-append-size file-select">
									<span><?= Yii::t('system', 'Размер') ?></span>
									<select></select>
								</label>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="filemanager-add-btn"><?= Yii::t('system', 'Вставить в запись') ?></button>
				</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>