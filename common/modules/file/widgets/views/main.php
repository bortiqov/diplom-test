<?php

use yii\widgets\LinkPager;

$context = $this->context;

$models = $context->model->getModels();
$pages = $context->model->getPagination();

?>

<div class="filemanager-files-container">
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