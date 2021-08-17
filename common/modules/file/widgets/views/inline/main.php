<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$context = $this->context;

$models = $context->model->getModels();
$pages = $context->model->getPagination();

?>

<div class="filemanager-files-container">
	<label class="filemanager-upload-btn">
		<span><?= Yii::t('main', 'Добавить новый') ?></span>
		<?= Html::hiddenInput('filemanager-input-' . $widget->id) . Html::fileInput('filemanager-input-' . $widget->id, '', ['multiple' => true, 'accept' => $accept]); ?>
	</label>
	<div class="filemanager-files files">
		<?php foreach($models as $model): ?>
			<?= $this->render('_item', [
				'model' => $model
			]); ?>
		<?php endforeach; ?>
	</div>
	<div class="filemanager-files-pagination">
		<?= LinkPager::widget([
			'pagination' => $pages,
			'nextPageLabel' => '',
			'prevPageLabel' => ''
		]);?>
	</div>
</div>