<?php

namespace common\modules\menu\components;

use common\modules\language\models\Language;
use common\modules\menu\models\MenuItems;
use common\modules\settings\models\Settings;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

class FrontendFooterMenu extends MenuRender
{

    public function init()
    {
        parent::init();
    }

    public function beforeRenderMenu()
    {
        echo '<ul class="nav float-md-right">';
    }

    public function afterRenderMenu()
    {
        echo '</ul>';
    }

    public function beginRenderItem()
    {
        if (!Yii::$app->user->isGuest && $this->item->url == '/site/login')
            echo ' <li><a class="nav-link" href="' . Url::to(['site/logout']) . '">' . __('Logout') . '</a></li>';
        else
            echo ' <li><a class="nav-link" href="' . $this->item->url . '">' . $this->item->title[Yii::$app->language] . '</a></li>';

    }

    private function menuItemSetting()
    {
        $model = MenuItems::findOne($this->item->menu_item_id);
        $langs = Language::find()->active()->all();

        echo '<div  class="menu-item-settings" menuitem-id="' . $this->item->menu_item_id . '"> ';
        $form = ActiveForm::begin([
            'id' => 'menu-item-form',
            'options' => ['data-pjax' => true, ['enctype' => 'multipart/form-data']]
        ]); ?>
        <div class="panel panel-default">
            <ul class="nav customtab nav-tabs">
                <?php foreach ($langs as $lang): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($lang->code == Yii::$app->language) ? 'active' : '' ?>" href="#fflanguage-<?= $lang->code ?>" data-toggle="tab"><?= mb_strtoupper($lang->code) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="tab-content" style="margin: 0">
                <?php
                foreach ($langs as $lang): ?>
                    <div class="tab-pane fade <?= ($lang->code == Yii::$app->language) ? 'active show' : '' ?>" style="opacity: 1" id="fflanguage-<?= $lang->code ?>">
                        <div class="panel panel-default">
                            <div class="panel-wrapper">
                                <div class="panel-body">
                                    <?= $form->field($model, 'title[' . $lang->code . ']')->textInput() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        echo $form->field($model, 'url');
        echo $form->field($model, 'icon');
        echo $form->field($model, 'menu_item_id')->hiddenInput()->label(false);
        echo Html::submitButton(Yii::t('app', 'Menu Update'), ['class' => 'btn btn-primary']);
        echo Html::a(Yii::t('app', 'Menu Remove'), '#menuitem', [
            'class' => 'btn btn-danger pull-right',
            'title' => 'delete',
            'data-query' => 'delete',
            'data-query-delete-selector' => 'li[menuitem-id=' . $this->item->menu_item_id . ']',
            'data-query-method' => 'POST',
            'data-query-url' => yii\helpers\Url::to(["/menu/menu/delete-item"]),
            'data-query-confirm' => Yii::t('app', 'Are you sure?'),
            'data-query-params' => 'id=' . $this->item->menu_item_id . '&menuItemDelete=delete'
        ]);
        ActiveForm::end();
        echo "</div>";
    }

    public function endRenderItem()
    {
    }

    public function beginRenderItemChild()
    {
    }

    public function endRenderItemChild()
    {
    }

    public function beforeRenderItemChilds()
    {
    }

    public function afterRenderItemChilds()
    {
    }
}
