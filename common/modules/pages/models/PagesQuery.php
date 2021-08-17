<?php

namespace common\modules\pages\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
/**
 * This is the ActiveQuery class for [[Pages]].
 *
 * @see Pages
 */
class PagesQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
        ];
    }
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return Pages[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Pages|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function slug($slug = null){
        if($slug == null){return false;}
        $this->active();
        $this->andWhere(['slug' => $slug]);
        return $this;
    }
}
