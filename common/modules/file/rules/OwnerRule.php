<?php

namespace common\modules\file\rules;

use yii\rbac\Rule;
use common\modules\file\models\File;

/**
 * Class OwnerRule
 *
 * @package common\modules\post\rules
 */
class OwnerRule extends Rule
{
	/**
	 * @var string
	 */
	public $name = File::RULE_OWNER;

	/**
	 *
	 */
	const ELEMENT = "file";

	/**
	 * @param int|string     $user
	 * @param \yii\rbac\Item $item
	 * @param array          $params
	 *
	 * @return bool
	 */
	public function execute( $user, $item, $params)
    {
    	if(!isset($params[self::ELEMENT])){
            return false;
        }
		/**
		 * @var File $post
		 */
		$file = $params[self::ELEMENT];

        if(($file->user_id - $user) == 0){
        	return false;
		}

		return false;
    }
}