<?php
/**
 * Created by PhpStorm.
 * User: utkir
 * Date: 08.08.2018
 * Time: 16:59
 */

namespace common\modules\tag\behaviors;


use common\modules\tag\models\Tag;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class TagBehavior
 * @package common\modules\tag\behaviors
 */
class TagBehavior extends Behavior
{
    /**
     * @var
     */
    public $attribute;
    /**
     * @var
     */
    public $relation_name;
    /**
     * @var
     */
    public $lang_attribute;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'saveData',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveData',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind'
        ];
    }

    /**
     *
     */
    public function saveData($event)
    {
        if(!$this->owner->isNewRecord){
           $this->unlinkData();
        }
        if(is_array($this->owner->{$this->attribute})){
            foreach ($this->owner->{$this->attribute} as $item){
                if($tag = Tag::findOne(['name'=>$item])){
                    $this->owner->link($this->relation_name,$tag);
                }else{
                    $tag = Tag::create($item,$this->owner->{$this->lang_attribute});
                    $this->owner->link($this->relation_name,$tag);
                }
            }
        }

    }

    /**
     * @return bool
     */
    private function unlinkData()
    {
        $relation_data = $this->owner->{$this->relation_name};
        if (count($relation_data) == 0) {
            return false;
        }
        foreach ($relation_data as $data):
            $this->owner->unlink($this->relation_name, $data, true);
        endforeach;
    }

    public function afterFind($event)
    {
        $this->owner->{$this->attribute} = ArrayHelper::map($this->owner->{$this->relation_name},'name','name');
    }

}