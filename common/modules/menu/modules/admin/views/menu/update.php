<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use common\modules\language\widgets\LangsWidgets;
use dosamigos\ckeditor\CKEditor;
use dosamigos\selectize\SelectizeDropDownList;
use dosamigos\selectize\SelectizeTextInput;
use kartik\widgets\Select2;
use kartik\editable\Editable;
use kartik\daterange\DateRangePicker;
use kartik\switchinput\SwitchInput;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\modules\menu\models\Menu */

$this->title = 'Menu:' . $model->title[Yii::$app->language];
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title[Yii::$app->language], 'url' => ['view', 'id' => $model->menu_id]];
$this->params['breadcrumbs'][] = 'Update';

Pjax::begin();
$this->registerJs(<<<JS
$(function  () {
    $(document).ready(function () {
        $("ol.menu-admin").sortable({
            handle: '.menu-item-title',
            onDrop: function(item, container, _super) {
                _super(item, container);
                var index = $(item).index() + 1;
                var element_id = $(item).attr("menuitem-id");
                var parent = $(item).parents()[1];
                console.log(parent);
                var parent_id = $(parent).attr("menuitem-id");
                $.ajax({
                    'type' : 'POST',
                    'data' : 'menuItemUpdate=ok&id=' + element_id + '&sort='+index +'&parent='+parent_id,
                    'url' : window.location.href,
                    'success' : function(data){
                        console.log(data);
                        $('.menu-admin li').each(function(index,itemli){
                            var index = $(itemli).index() + 1;
                            var element_id = $(itemli).attr("menuitem-id");
                            var parent = $(itemli).parents()[1];
                            var parent_id = $(parent).attr("menuitem-id");
                            $.ajax({
                                'type' : 'POST',
                                'data' : 'menuItemUpdate=ok&id=' + element_id + '&sort='+index +'&parent='+parent_id,
                                'url' : window.location.href,
                            });
                        });
                    }
                });
            },
        });
        $('.menu-item-get-settings').click(function(e){
            var parent = $(this).parents("li");
            var menu_id = parent.attr('menuitem-id');
            $('.menu-item-settings[menuitem-id='+menu_id+']').toggle();
        });
    });

});
JS
);
?>


    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>
            </div>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'menuItem' => $menuItem
    ]) ?>

<?php

$this->registerJs('query_handler();');
?>
<?php Pjax::end(); ?>
