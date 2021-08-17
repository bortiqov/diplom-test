<?php

namespace common\modules\post\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\post\models\Post]].
 *
 * @see \common\modules\post\models\Post
 */
class PostQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\modules\post\models\Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\post\models\Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
