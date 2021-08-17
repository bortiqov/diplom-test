<?php

namespace common\modules\file\widgets;

use common\modules\file\assets\FilemanagerAsset;
use common\modules\file\models\File;
use common\modules\user\models\User;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\InputWidget;
use common\modules\file\models\FileSearch;

/**
 * Class FileManagerModal
 *
 * @package common\modules\file\widgets
 */
class FileManagerEditorModal extends InputWidget
{
	/**
	 * @var string
	 */
	public $id = 'editor';

	/**
	 * @var array
	 */
	private static $_allowed_types = [
		'image',
		'audio',
		'video'
	];

	/**
	 * @var string
	 */
	public $upload_url = '/file/file/upload';

	/**
	 * @var string
	 */
	public $detail_view_url = '/file/file/detail';

	/**
	 * @var string
	 */
	public $detail_update_url = '/file/file/update-detail';

	/**
	 * @var string
	 */
	public $user_id = null;

	/**
	 * @var string
	 */
	public $secure = false;

	/**
	 *
	 */
	public function init()
    {
        parent::init();

		FilemanagerAsset::register(Yii::$app->view);

        $file_detail_url = Url::to([$this->detail_view_url]);
        $file_update_detail_url = Url::to([$this->detail_update_url]);

		$script =  <<<JS
		
			var filemanager = function(editor)
			{
				var self = this;
				this.editor = editor;
				this.self_block    = '#filemanager-{$this->id}';
				this.item          = '.filemanager-item';
				this.item_detail   = 'filemanager-item-detail';
				this.item_name     = '.filemanager-item-name';
				this.all_items     = '.filemanager-files';
				this.selected_item = 'selected-item';
				this.file_input    = '.filemanager-file-input';
				this.add_btn       = '.filemanager-add-btn';
				this.modal         = '#filemanager-modal-{$this->id}';
				this.modal_sidebar = '.modal-sidebar';
				this.item_detail_block = '.filemanager-item-detail-block';
				this.item_image    = 'filemanager-item-image';
				this.item_saved    = '.filemanager-item-saved';
				this.item_settings = '.filemanager-item-settings';
				this.sortable      = '.sortable';
				this.filemanager_sortable_item = '.filemanager-sortable-item';
				this.filemanager_sortable_item_remove = '.filemanager-sortable-item-remove';
				this.selected = [];
				this.response = {};
				
				this.showDetails = function() 
				{
					var selected_item = $(self.self_block + ' .' + self.item_detail);
					var item_detail = $(self.self_block + ' ' + self.item_detail_block);
					if(selected_item.length > 0){
						var file_id = selected_item.data('id');
						if(file_id > 0){
							item_detail.show();
							item_detail.attr('data-id', file_id);
					
							item_detail.closest(self.modal_sidebar).addClass('loading-data');
							
							var file_mime_type = item_detail.find('.file-mime_type span'),
								file_date_create = item_detail.find('.file-date_create span'),
								file_size = item_detail.find('.file-size span'),
								thumbnail = item_detail.find('.thumbnail img'),
								file_resolution = item_detail.find('.file-resolution'),
								file_url = item_detail.find('.file-url input'),
								file_title = item_detail.find('.file-title input'),
								file_caption = item_detail.find('.file-caption textarea'),
								file_description = item_detail.find('.file-description textarea'),
								file_append_size = item_detail.find('.file-append-size select');
								file_append_link = item_detail.find('.file-append-link select');
							
							file_mime_type.text('');
							thumbnail.attr('src', '');
							file_resolution.hide();
							file_url.val('');
							file_title.val('');
							file_caption.val('');
							file_description.val('');
							file_append_size.empty();
							
							self.response = {};
							
							$.ajax({
								url: '{$file_detail_url}?file_id=' + file_id,
								type: 'GET',
								success: function(response) 
								{
									self.response = response;
									
									file_mime_type.text(response.mime_type);
									file_date_create.text(response.date_create);
									file_size.text(response.size);
									if(response.isImage){
										thumbnail.attr('src', response.thumb_url);
										file_resolution.show().find('span').text(response.resolutions.medium.width + ' × ' + response.resolutions.medium.height);
										item_detail.addClass(self.item_image)
									} else {
										file_resolution.hide();
										item_detail.removeClass(self.item_image)
									}
									
									file_url.val(response.url);
									file_title.val(response.title);
									file_caption.val(response.caption);
									file_description.val(response.description);
										
									$.map(response.resolutions, function(item) {
										file_append_size.append('<option value="' + item.link + '">' + item.title + ' - ' + item.width + ' × ' + item.height + '</option>');
									});
									
									if(response.resolutions.medium){
									    file_append_size.val(response.resolutions.medium.link);
									}
									
									if(response.isImage){
										file_append_size.parent().show();
									} else {
										file_append_size.parent().hide();
									}
									
									item_detail.closest(self.modal_sidebar).removeClass('loading-data');
								},
								error: function(e) 
								{
									//item_detail.closest(self.modal_sidebar).removeClass('loading-data');
								}
							});
						}
					} else {
						item_detail.hide();
						$(self.self_block + ' ' + self.item_detail_block).attr('data-id', '');
					}
				};
				
				this.updateDetails = function(item_detail) 
				{
					var item_detail = $(self.self_block + ' ' + self.item_detail_block);
					var title = item_detail.find('.file-title input').val();
					var caption = item_detail.find('.file-caption textarea').val();
					var description = item_detail.find('.file-description textarea').val();
					if(self.selected.length == 0) return false;
					var file_id = self.selected[self.selected.length - 1];
					if(file_id > 0){
						item_detail.find(self.item_saved).hide();
						item_detail.closest(self.modal_sidebar).addClass('loading-data');
						$.ajax({
							url: '{$file_update_detail_url}?file_id=' + file_id,
							type: 'POST',
							data: {
								File: {
									title: title,
									caption: caption,
									description: description
								}
							},
							success: function(response) 
							{
								if(response.success == true){
									item_detail.find(self.item_saved).show();
									setTimeout(function() {
										item_detail.find(self.item_saved).hide();
									}, 3000);
								}
								$(self.self_block + ' ' + self.all_items + ' ' + self.item + '[data-id="' + file_id + '"] ' + self.item_name).text(response.title);
								item_detail.closest(self.modal_sidebar).removeClass('loading-data');
							},
							error: function(e) 
							{
								item_detail.closest(self.modal_sidebar).removeClass('loading-data');
							}
						});
					}
				};
				
				this.reset = function() 
				{
					self.selected = [];
					$(self.self_block + ' ' + self.all_items + ' ' + self.item).each(function() {
						$(this).removeClass(self.selected_item).removeClass(self.item_detail);
					});
					self.showDetails();
				};
				
				this.addToInput = function() 
				{
					var sidebar = $(self.self_block + ' ' + self.modal_sidebar);
					var src = sidebar.find('.file-append-size select').val();
					var link = sidebar.find('.file-append-link select').val();
					var link_value = sidebar.find('.file-append-link input').val();
					
					if(link == 'none'){
						self.editor.insertHtml('<img src="' + src + '" />');
					} else {
						self.editor.insertHtml('<a class="content-image" href="' + link_value + '"><img src="' + src + '" /></a>');
					}
				};
				
				this.init = function()
				{
					$(document).on('click', self.self_block + ' ' + self.item, function(e) {
						
						var file_id = $(this).data('id');
						
						$(this).closest(self.all_items).find(self.item).removeClass(self.item_detail).removeClass(self.selected_item);
						
						$(this).addClass(self.selected_item).addClass(self.item_detail);
						
						if(self.selected.includes(file_id)) {  
							self.selected = [];
						} else {
							self.selected.push(file_id);
							$(this).addClass(self.selected_item).addClass(self.item_detail);
						}

						if(self.selected.length === 0){
							$(self.self_block).find(self.add_btn).attr('disabled', true);
						} else {
							$(self.self_block).find(self.add_btn).attr('disabled', false);
						}
						self.showDetails();
					});
					
					$(document).on('change', self.self_block + ' ' + self.modal_sidebar + ' .file-append-link select', function() {
						var value = $(this).val();
						var input = $(this).parent().find('input');
						if(value == 'none'){
							input.addClass('hidden');
						} else {
							input.removeClass('hidden');
							
							if(Object.keys(self.response).length !== 0){
								if(value == 'file'){
									input.val(self.response.resolutions.full.link)
								} else {
									input.val('http://')
								}
							}
						}
					});
					
					$(document).on('click', self.self_block + ' ' + self.add_btn, function() {
						self.addToInput();
						$(self.modal).modal('hide');
					});
					
					$(document).on('click', self.self_block + ' ' + self.item_settings + ' button', function(e) {
						e.preventDefault();
						self.updateDetails();
					});
					$(self.self_block + ' ' + self.modal).on('hide.bs.modal', function (e) {
						self.reset();
					});
					$(self.self_block + ' ' + self.modal).on('show.bs.modal', function (e) {
						self.reset();
					});
				};
				
				this.init();
			
				this.run = function(editor){
					self.editor = editor;
					$(self.modal).modal('show');
				}
			};

			document.filemanager_{$this->id} = new filemanager(); 

JS;
		Yii::$app->view->registerJS($script);
    }

	/**
	 * @return string|void
	 */
	public function run()
    {
		$searchModel = new FileSearch();

		if($this->user_id){
			$searchModel->user_id = $this->user_id;
		}

		if(!Yii::$app->user->can(User::STATUS_ACTIVE)){
			$searchModel->user_id = Yii::$app->user->getId();
		}

		$searchModel->secure = (int) $this->secure;

		$model = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('FileManagerEditorModal', [
			'model'     => $model,
			'widget'    => $this,
			'allowed_types' => self::$_allowed_types
		]);
    }
}
