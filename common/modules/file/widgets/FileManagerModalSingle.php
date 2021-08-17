<?php

namespace common\modules\file\widgets;

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
class FileManagerModalSingle extends InputWidget
{
	/**
	 * @var string
	 */
	public $attribute = '';

	/**
	 * @var string
	 */
	public $form;

	/**
	 * @var string
	 */
	public $mime_type = '';

	/**
	 * @var bool
	 */
	public $multiple = true;

	/**
	 * @var string
	 */
	public $via_relation = "image";

	/**
	 * @var string
	 */
	public $relation_column = "image_id";

	/**
	 * @var
	 */
	public $model_db;

	/**
	 * @var string
	 */
	public $delimitr = ',';

	/**
	 * @var array
	 */
	private static $_allowed_types = [
		'image',
		'audio',
		'video'
	];

	/**
	 * @var array
	 */
	private $selected = [];

	/**
	 * @var array
	 */
	private $selected_items_sortable = [];

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
	public $file_delete_url = '/file/file/delete-file';

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

		if(empty($this->attribute)) {
			throw new InvalidConfigException('"attribute" cannot be empty.');
		}

        $file_detail_url = Url::to([$this->detail_view_url]);
        $file_update_detail_url = Url::to([$this->detail_update_url]);
		$file_delete_url = Url::to([$this->file_delete_url]);

		$script =  <<<JS
		
			var filemanager = function()
			{
				var self = this;
				this.self_block    = '#filemanager-{$this->id}';
				this.item          = '.filemanager-item';
				this.item_detail   = 'filemanager-item-detail';
				this.item_name     = '.filemanager-item-name',
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
				this.items_delete_all = '.delete-selected-all';
				this.sortable      = '.sortable';
				this.filemanager_sortable_item = '.filemanager-sortable-item';
				this.filemanager_sortable_item_remove = '.filemanager-sortable-item-remove';
				this.delimiter     = ',';
				this.selected      = [];
				this.multiple      = Number({$this->multiple});
				
				this.checkItem = function(file_id, file_title, file_img, file_isimg) 
				{
					var item_image = '';
					if(file_isimg == 1){
						item_image = 'filemanager-sortable-item-image';
					}
						
					if(self.multiple){
							console.log(file_id);
						if(self.selected.includes(file_id)) {  
							self.selected.splice(self.selected.indexOf(file_id), 1);
							$(self.self_block + ' ' + self.sortable + ' li[data-key="' + file_id + '"]').remove();
							return true;
						} else {
							self.selected.push(file_id);
							$(self.self_block + ' ' + self.sortable).append('<li data-key="' + file_id + '" draggable="true"><div data-id="' + file_id + '" class="filemanager-sortable-item ' + item_image + '"><img src="' + file_img + '"/><i class="filemanager-sortable-item-icon glyphicon glyphicon-file"></i><span class="filemanager-sortable-item-name">' + file_title + '</span><span class="filemanager-sortable-item-remove"><i class="glyphicon glyphicon-remove"></i></span></div></li>');
							
							return false;
						}
					} else {
						self.selected = [];
						$(self.self_block + ' ' + self.sortable + ' li').remove();
						
						$(self.self_block + ' ' + self.sortable).append('<li data-key="' + file_id + '" draggable="true"><div data-id="' + file_id + '" class="filemanager-sortable-item ' + item_image + '"><img src="' + file_img + '"/><i class="filemanager-sortable-item-icon glyphicon glyphicon-file"></i><span class="filemanager-sortable-item-name">' + file_title + '</span><span class="filemanager-sortable-item-remove"><i class="glyphicon glyphicon-remove"></i></span></div></li>');
						
						self.selected.push(file_id);
						return false;
					}
				};
				
				this.deleteItem = function(item) {
					var file_id = item.closest(self.filemanager_sortable_item).data('id');
				  	self.selected.splice(self.selected.indexOf(file_id), 1);
					$(self.self_block + ' ' + self.sortable + ' li[data-key="' + file_id + '"]').remove();
					self.addToInput();
					return true;
				};
				
				this.checkItems = function() 
				{
					if(self.selected.length > 0) 
						$(self.self_block + ' ' + self.item + '[data-id="' + self.selected[self.selected.length - 1] + '"]').addClass(self.item_detail);
					$(self.self_block + ' ' + self.all_items + ' ' + self.item).each(function() {
						if(self.selected.includes($(this).data('id'))){
							$(this).addClass(self.selected_item);
						} else {
							$(this).removeClass(self.selected_item);
						}
					});
					self.showDetails();
				};
				
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
							
							item_detail.find('.file-url input').val('');
							item_detail.find('.file-mime_type span').text('');
							item_detail.find('.thumbnail img').attr('src', '');
							item_detail.find('.file-resolution').hide();
							item_detail.find('.file-url input').val('');
							item_detail.find('.file-title input').val('');
							item_detail.find('.file-caption textarea').val('');
							item_detail.find('.file-description textarea').val('');
							
							$.ajax({
								url: '{$file_detail_url}?file_id=' + file_id,
								type: 'GET',
								success: function(response) 
								{
									item_detail.find('.file-mime_type span').text(response.mime_type);
									item_detail.find('.file-date_create span').text(response.date_create);
									item_detail.find('.file-size span').text(response.size);
									if(response.isImage){
										item_detail.find('.thumbnail img').attr('src', response.thumb_url);
										item_detail.find('.file-resolution').show().find('span').text(response.resolutions.medium.width + ' x ' + response.resolutions.medium.height);
										item_detail.addClass(self.item_image)
									} else {
										item_detail.find('.file-resolution').hide();
										item_detail.removeClass(self.item_image)
									}
									
									item_detail.find('.file-url input').val(response.url);
									item_detail.find('.file-title input').val(response.title);
									item_detail.find('.file-caption textarea').val(response.caption);
									item_detail.find('.file-description textarea').val(response.description);
									
									item_detail.closest(self.modal_sidebar).removeClass('loading-data');
								},
								error: function(e) 
								{
									item_detail.closest(self.modal_sidebar).removeClass('loading-data');
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
				
				this.deleteFile = function(item_detail) 
				{
					var item_detail = $(self.self_block + ' ' + self.item_detail_block);
					if(!confirm("Are you sure?")){return false;}
					if(self.selected.length == 0) return false;
					var file_id = self.selected[self.selected.length - 1];
					if(file_id > 0){
						item_detail.find(self.item_saved).hide();
						item_detail.closest(self.modal_sidebar).addClass('loading-data');
						$.ajax({
							url: '{$file_delete_url}?file_id=' + file_id,
							type: 'POST',
							success: function(response) 
							{
								var item = $(self.self_block + ' ' + self.all_items + ' ' + self.item + '[data-id="' + file_id + '"] ');
								var sortableitem = $(self.self_block + ' ' + self.filemanager_sortable_item + '[data-id="' + file_id + '"] ');
								item.remove();
								item_detail.closest(self.modal_sidebar).removeClass('loading-data');
								self.selected = [];
								self.deleteItem(sortableitem);
								self.addToInput();
								self.checkItems();
							},
							error: function(e)
							{
								item_detail.closest(self.modal_sidebar).removeClass('loading-data');
							}
						});
					}
				};
				
				this.deleteAll = function() {
					var selecteds = self.selected;
					if(selecteds.length > 0){
						selecteds.forEach(function(selected){
							$.ajax({
								url: '{$file_delete_url}?file_id=' + selected,
								type: 'POST',
								success: function(response) 
								{
									var item = $(self.self_block + ' ' + self.all_items + ' ' + self.item + '[data-id="' + selected + '"] ');
									var sortableitem = $(self.self_block + ' ' + '.sortable [data-key="' + selected + '"] ');
									sortableitem.remove();
									item.remove();
									item_detail.closest(self.modal_sidebar).removeClass('loading-data');
									self.selected = [];
									self.deleteItem(sortableitem);
									self.addToInput();
									self.checkItems();
								},
								error: function(e) 
								{
									item_detail.closest(self.modal_sidebar).removeClass('loading-data');
								}
							});
						})
					}
				};
				
				this.addToInput = function() 
				{
					$(self.self_block + ' ' + self.file_input).val(self.selected.join());
				};
				
				this.addCroppedToInput = function(selected) 
				{
					$(self.self_block + ' ' + self.file_input).val(selected);
					self.checkItems();
					$(self.self_block + ' ' + self.sortable).find('li').remove();
					var selectedItem = $(self.self_block + ' ' + self.all_items).find(self.item + '[data-id="' + selected + '"]');
					var file_id = selectedItem.data('id');
					var file_title = selectedItem.data('title');
					var file_img = selectedItem.data('image');
					var file_isimg = selectedItem.data('isimage');
					self.checkItem(file_id, file_title, file_img, file_isimg);
					$(self.self_block + ' ' + self.modal).modal('hide');
				};
				
				this.getInputVal = function() 
				{
					var selected = $(self.self_block + ' ' + self.file_input).val();
					if(selected.length > 0){
						self.selected = selected.split(self.delimiter);
						self.selected = self.selected.map(Number);
					}
				};
				
				this.init = function()
				{
					self.getInputVal();
					
					$(document).on('click', self.self_block + ' ' + self.filemanager_sortable_item_remove,  function() {
						if(!confirm("Are you sure?")){return false;}
						self.deleteItem($(this));
					});
					
					$(document).on('click', self.self_block + ' ' + self.item, function(e) {
						$(this).closest(self.all_items).find(self.item).removeClass(self.item_detail);
						var file_id = $(this).data('id');
						var file_title = $(this).data('title');
						var file_img = $(this).data('image');
						var file_isimg = $(this).data('isimage');
						if(self.checkItem(file_id, file_title, file_img, file_isimg)){
							$(this).removeClass(self.selected_item);
							if(self.selected.length > 0) 
								$(this).closest(self.all_items).find(self.item + '[data-id="' + self.selected[self.selected.length - 1] + '"]').addClass(self.item_detail);
						} else {
							$(this).addClass(self.selected_item).addClass(self.item_detail);
						}
						if(self.multiple == 0){
							$(this).closest(self.all_items).find(self.item).not(this).removeClass(self.selected_item);
						}
						self.addToInput();

						if(self.selected.length === 0){
							$(self.self_block).find(self.add_btn).attr('disabled', true);
						} else {
							$(self.self_block).find(self.add_btn).attr('disabled', false);
						}
						self.showDetails();
					});
					
					$(document).on('click', self.self_block + ' ' + self.add_btn, function() {
						self.addToInput();
						$(self.modal).modal('hide');
					});
					$(document).on('click', self.self_block + ' ' + self.item_settings + ' .file-update', function(e) {
						e.preventDefault();
						self.updateDetails();
					});
					$(document).on('click', self.self_block + ' ' + self.item_settings + ' .file-delete', function(e) {
						e.preventDefault();
						self.deleteFile();
					});
					$(self.self_block + ' ' + self.modal).on('hide.bs.modal', function (e) {
						self.getInputVal();
						self.checkItems();
					});
					$(self.self_block + ' ' + self.modal).on('show.bs.modal', function (e) {
						$.pjax.reload({container: '#files-pjax-modal-{$this->id}', timeout: false});
						self.getInputVal();
						self.checkItems();
					});
					$(self.self_block + ' ' + self.items_delete_all).on('click', function (e) {
						self.getInputVal();
						self.deleteAll();
					});
				};
				
				this.init();
			};

			document.filemanager_{$this->id} = new filemanager(); 

JS;
		Yii::$app->view->registerJS($script);
		$this->selected = [];
		if($this->model_db->{$this->via_relation}){
			$file = File::findOne($this->model_db->{$this->via_relation});
			if($file === null){ return false;}
			$this->selected[] = $file->id;
			$isImage = $file->getIsImage() ? "filemanager-sortable-item-image" : "";

			$this->selected_items_sortable[$file->id]['content'] = '<div data-id="' . $file->id . '" class="filemanager-sortable-item ' . $isImage . '"><img src="' . $file->getSrc('small') . '"/><i class="filemanager-sortable-item-icon glyphicon glyphicon-file"></i><span class="filemanager-sortable-item-name">' . Html::encode($file->title) . '</span><span class="filemanager-sortable-item-remove"><i class="glyphicon glyphicon-remove"></i></span></div>';


		}
		$this->selected = implode($this->delimitr, $this->selected);
    }

	/**
	 * @return string|void
	 */
	public function run()
    {
		$searchModel = new FileSearch();
		if($this->mime_type && in_array($this->mime_type, self::$_allowed_types))
			$searchModel->mime_type = $this->mime_type;

		if($this->user_id){
			$searchModel->user_id = $this->user_id;
		}

		$searchModel->secure = (int) $this->secure;

		$model = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('FileManagerModal', [
			'model'     => $model,
			'widget'    => $this,
			'form'      => $this->form,
			'selected'  => $this->selected,
			'selected_items_sortable' => $this->selected_items_sortable,
			'mime_type' => $this->mime_type,
			'allowed_types' => self::$_allowed_types
		]);
    }
}
