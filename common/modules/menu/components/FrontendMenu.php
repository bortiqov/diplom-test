<?php

namespace common\modules\menu\components;

use common\modules\language\models\Language;
use common\modules\menu\models\MenuItems;
use common\modules\settings\models\Settings;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

class FrontendMenu extends MenuRender
{

    public function init()
    {
        parent::init();
    }

    public function beforeRenderMenu()
    {
        echo '<ul class="rightNav">';
    }

    public function renderHelperButtons()
    {
        echo '<li><div class="switchLang">
              <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                  <img src="/images/icons/' . mb_strtoupper(Yii::$app->language) . '.svg" alt="" /> '. __("Switch to ") . mb_strtoupper(Yii::$app->language) . '
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';
        foreach (Language::find()->all() as $lang):
            $active = (Yii::$app->language == $lang->code) ? "active" : "";
            echo '<li>
                    <a href="' . Url::current(['language' => $lang->code]) . '" class="dropdown-item ' . $active . ' ">
                      <img src="/images/icons/' . mb_strtoupper($lang->code) . '.svg" alt="" /> ' . __("Switch to ") . mb_strtoupper($lang->code) . '
                    </a>
                  </li>';
        endforeach;
        echo '</ul>
              </div>
            </div>
            </li>';
    }

    public function afterRenderMenu()
    {
        $this->renderHelperButtons();
        echo '</ul>';
    }

    public function beginRenderItem()
    {

        if ($this->has_child) {
            echo '<li>
                    <a href="#" class="top10 nav-link"> ' . $this->item->title[Yii::$app->language] . '
                        <img class="top-chevron" src="/images/right-chevron.png" alt="">';
        } else {
            echo '<li>';
            echo '<a href=" ' . Url::to([$this->item->url]) . ' " class="navLink"> ' . $this->item->title[Yii::$app->language] . '</a>';
        }

    }

    private function menuItemSetting()
    {
    }

    public function endRenderItem()
    {
        if ($this->has_child):
            echo '</ul></li>';
        else:
            echo '</li>';
        endif;
    }

    public function beginRenderItemChild()
    {
        echo '<li>';
        foreach (Language::find()->all() as $lang):
            echo '<a href="' . Url::current(['language' => $lang->code]) . '" class="switchLang">
                            <img src="/images/icons/EN.svg" alt=""/>
                        </a>';
        endforeach;
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
