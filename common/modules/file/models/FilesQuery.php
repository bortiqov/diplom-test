<?php

namespace common\modules\file\models;

/**
 * Class FilesQuery
 *
 * @package common\modules\file\models
 */
class FilesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

	/**
	 * @param null $db
	 *
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public function all($db = null)
    {
        return parent::all($db);
    }

	/**
	 * @param null $db
	 *
	 * @return array|null|\yii\db\ActiveRecord
	 */
	public function one($db = null)
    {
        return parent::one($db);
    }
}
