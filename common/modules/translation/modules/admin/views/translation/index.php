<?php

use common\modules\language\models\Language;
use common\modules\translation\models\Message;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use common\modules\langs\models\Langs;

$this->title                   = Yii::t('main', 'Translations');
$this->params['breadcrumbs'][] = $this->title;

$searchModel->language = Yii::$app->language;

$show_url   = Url::to(["/translation/translation/translate"]);
$delete_url = Url::to(["/translation/translation/delete"]);
$message    = addslashes(Yii::t('main', "Are you sure to delete message?"));

$js = <<<JS

    $(document).ready(function() {
        $('#modal_translation').iziModal({
            autoOpen: !1,
            focusInput: !0,
            radius: "5px",
            overlayClose: !0,
            overlayColor: "rgba(0,0,0,0.3)",
            bodyOverflow: !0
        });

        $('.show-translation').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $('#translation_body').load('{$show_url}?id=' + id, function (data) {
                $('#modal_translation').iziModal("open");
                $('#delete-button').attr('trans-id', id);
            });
        });
    
        $('#close-button').click(function(e) {
            e.preventDefault();
            $('#modal_translation').iziModal('close');
        });
    
        $('#delete-button').click(function(e) {
            e.preventDefault();
            if (confirm('{$message}')){
                $.ajax('{$delete_url}?id=' + $('#delete-button').attr('trans-id'),{
                    method: 'GET',
                    success: function () {
                        $('#modal_translation').iziModal('close');
                        $('#data-grid-filters input:first').trigger('change');
                    }
                });
            }
            return false;
        });
        
        $('#save-button').click(function(e) {
            e.preventDefault();
            var form = $('#translation-form');
            $.post(form.attr('action'), form.serialize(), function () {
                $('#modal_translation').iziModal('close');
                $('#data-grid-filters input:first').trigger('change');
                return false;
            });
            return false;
        });
    });
 
JS;

$this->registerJs($js);

$out       = [];
$languages = Language::find()->select(['id', 'code', 'name'])->orderBy(['id' => SORT_ASC])->all();

foreach ($languages as $language) {
	$out[] = [
		'label'  => $language->name,
		'format' => 'raw',
		'headerOptions' => ['style' => 'text-align:center;min-width:150px;max-width:150px;width:150px;overflow:hidden'],
		'contentOptions' => ['style' => 'text-align:center;min-width:150px;max-width:150px;width:150px;overflow:hidden;'],
		'value'  => function ($model) use ($language)
		{
			$query = Message::findOne(['language' => $language->code, 'id' => $model->id]);

			return ($query instanceof Message) ? StringHelper::truncate($query->translation, 100) : '';
		},
	];
}

//$out[] = [
//	'class' => 'yii\grid\ActionColumn',
//	'header' => Yii::t('main','Actions'),
//	'headerOptions' => ['style' => 'text-align:center;min-width:100px;max-width:100px;width:100px'],
//	'template' => '{buttons}',
//	'contentOptions' => ['style' => 'min-width:100px;max-width:100px;width:100px', 'class' => 'v-align-middle'],
//	'buttons' => [
//		'buttons' => function ($url, $model)
//		{
//			$delete = Url::to(['/language/translation/delete', 'id' => $model->id]);
//			$code = <<<BUTTONS
//                <div class="btn-group flex-center">
//                    <a class="btn btn-info btn-icon show-translation" data-id="{$model->id}">
//                         <div>
//                            <i class="icon-pencil"></i>
//						</div>
//                    </a>
//                    <a href="{$delete}" data-confirm="Are you sure?" data-method="post" class="btn btn-danger btn-icon">
//                        <div>
//                            <i class="icon-trash"></i>
//						</div>
//                    </a>
//                </div>
//BUTTONS;
//			return $code;
//		}
//
//	],
//];

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body page-header-block">
                    <div class="row">
                        <div class="col-md-6">
                            <h2><?= Html::encode($this->title) ?></h2>
                        </div>
                        <div class="col-md-6" id="data-grid-filters">
                            <?php $form = ActiveForm::begin(); ?>
                            <?= $form->field($searchModel, 'search', ['options' => ['class' => 'form-group m-b-0'], 'labelOptions' => ['class' => 'invisible']])->textInput(['autofocus' => true, 'placeholder' => $searchModel->getAttributeLabel('search')])->label(false) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <?= GridView::widget([
                            'id'           => 'data-grid',
                            'dataProvider' => $dataProvider,
                            'columns'      => ArrayHelper::merge(
                                [
                                    [
                                        'attribute' => 'message',
                                        'format'    => 'raw',
                                        'contentOptions' => ['class' => 'v-align-middle'],
                                        'value'     => function ($data)
                                        {
                                            return Html::a($data->message, '#', ['class' => 'show-translation', 'data-id' => $data->id, 'data-pjax' => 0]);
                                        },
                                    ],
                                ],
                                $out
                            )
                        ] ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_translation" class="modal-lg iziModal">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; padding: 20px; border-bottom: 1px solid #e5e5e5;">
                <h4 class="modal-title"><?= Yii::t('main', 'Translate Message') ?></h4>
                <div data-izimodal-close="#modal_translation" class="close_button">&times;</div>
            </div>
            <div class="modal-body" id="translation_body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" id="delete-button"><?= Yii::t('main', 'Delete') ?></button>
                <button type="button" class="btn btn-default" id="close-button"><?= Yii::t('main', 'Close') ?></button>
                <button type="button" class="btn btn-primary" id="save-button"><?= Yii::t('main', 'Update') ?></button>
            </div>
        </div>
    </div>
</div>