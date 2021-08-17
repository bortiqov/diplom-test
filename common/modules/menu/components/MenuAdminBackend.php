<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.03.2018
 * Time: 17:05
 */

namespace common\modules\menu\components;


use Yii;

class MenuAdminBackend extends MenuRender
{

    public $checkAccess = true;

    public function beforeRenderMenu()
    {
        echo '<ul class="vertical-menu">';
    }

    public function afterRenderMenu()
    {
        echo '</ul>';
    }

    public function beginRenderItem()
    {

        echo ' <li><a class="nav-link" href="' . $this->item->url . '">';
        echo '<i class="ni ' . $this->item->icon . ' text-default"></i> <span>' . $this->item->title[Yii::$app->language] . '</span>';
        if ($this->has_child):
            echo '<i class="feather icon-chevron-right pull-right"></i>';
        endif;
        echo ' </a>';
    }

    public function endRenderItem()
    {
        echo "</li>";
    }

    public function beginRenderItemChild()
    {
        if ($this->is_active()):
            echo '<li class="current">';
        else:
            echo '<li>';
        endif;

        echo '<a href="' . $this->item->url . '" class="detailed"> <span class="title">' . $this->item->title[Yii::$app->language] . '</span></a>';
        echo '</li>';

    }

    public function endRenderItemChild()
    {
        echo '</li>';
    }

    public function beforeRenderItemChilds()
    {
        echo ' <ul class="sub-menu">';
    }

    public function afterRenderItemChilds()
    {
        echo '</ul>';
    }

}
