<?php


namespace common\modules\tag\behaviors;


use common\modules\tag\models\tag;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

class ModelBehavior extends AttributeBehavior {
    /**
     * @var string
     */
    public $attribute = "tags";

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT  => 'save',
            ActiveRecord::EVENT_BEFORE_UPDATE  => 'save'
        ];
    }

    /**
     *
     */
    public function save()
    {
        if(!$this->owner->isNewRecord) {
            $this->unlink();
        }

        $this->link();
    }

    /**
     * @return bool
     */
    private function unlink()
    {
        $tags = $this->owner->tags;

        if(count($tags) == 0){
            return false;
        }

        foreach ($tags as $tag) {
            $this->owner->unlink('tags', $tag, true);
        }
    }

    /**
     * @return bool
     */
    private function link()
    {
        $ids = $this->owner->{$this->attribute};

        if(empty($ids)){
            return false;
        }

        $tags = tag::find()->where(['id' => $ids])->all();

        if(!$tags){
            return false;
        }

        foreach($tags as $tag) {
            $this->owner->link('tags', $tag);
        }
    }
}
