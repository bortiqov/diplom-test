<?php
namespace common\modules\language\components;

use Yii;
use yii\base\Behavior;
use yii\base\Model;

class QueryBehavior extends Behavior{

    public $attribute = 'lang';

    public $alias = null;

    public function lang($alias = null){
        if($alias !== null){
            return $this->owner->andWhere([$alias.".".$this->attribute => Lang::getLangId()]);
        }
        if($this->alias !== null){
            return $this->owner->andWhere([$this->alias.".".$this->attribute => Lang::getLangId()]);
        }
        return $this->owner->andWhere([$this->attribute => Lang::getLangId()]);
    }
}