<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\modules\language\models\Language;

?>

<div class="row">
    <?php $form = ActiveForm::begin([
		'action' => Url::to(['/translation/translation/translate', 'id' => $model->id]),
		'id'     => 'translation-form',
        'options' => [
            'class' => 'col'
        ]
    ]); ?>
	    <div class="col col-md-12">
	        <div class="form-group">
	            <label class="control-label" for="translation-message"><?= Yii::t('main', 'Message') ?></label>
	            <p id="translation-message"><?= $model->message ?></p>
	            <hr>
	        </div>
	        <?php foreach ($messages as $language => $value): ?>
	            <div class="form-group">
	                <label class="control-label" for="translation-<?= $language ?>">
	                    <?= Language::findOne(['code' => $language])->name ?>
	                </label>
	                <input type="text" class="form-control" id="translation-<?= $language ?>" name="translation[<?= $language ?>]" value="<?= $value ?>">
	            </div>
	        <?php endforeach ?>
	    </div>
    <?php ActiveForm::end(); ?>
</div>