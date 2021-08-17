<?php

namespace common\modules\user\models;

/**
 * This is the ActiveQuery class for [[\common\modules\user\models\UserBookmark]].
 *
 * @see \common\modules\user\models\UserBookmark
 */
class UserBookmarkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\modules\user\models\UserBookmark[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\user\models\UserBookmark|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
