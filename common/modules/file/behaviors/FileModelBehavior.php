<?php

namespace common\modules\file\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use common\modules\file\models\File;

/**
 * Class FileModelBehavior
 *
 * @package common\filemanager\behaviors
 */
class FileModelBehavior extends AttributeBehavior
{
	/**
	 * @var string
	 */
	public $attribute = "post_file_data";
	/**
	 * @var string
	 */
	public $relation_name = "postFiles";
	/**
	 * @var string
	 */
	public $delimitr = ",";
	/**
	 * @var string
	 */
	public $via_table_name = "post_file";
	/**
	 * @var string
	 */
	public $via_table_relation = "post_file";
	/**
	 * @var string
	 */
	public $one_table_column = "post_id";
	/**
	 * @var string
	 */
	public $two_table_column = "file_id";

	/**
	 * @return array
	 */
	public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT  => 'saveData',
            ActiveRecord::EVENT_BEFORE_UPDATE  => 'saveData'
        ];
    }

	/**
	 *
	 */
	public function saveData()
	{
        if(!$this->owner->isNewRecord) {
			$this->unlinkData();
		}
        $this->linkData();
    }

	/**
	 * @return bool
	 */
	private function unlinkData()
	{
        $relation_data = $this->owner->{$this->relation_name};
        if(count($relation_data) == 0){return false;}
        foreach ($relation_data as $data) {
			$this->owner->unlink( $this->relation_name, $data, true );
		}
    }

	/**
	 * @return bool
	 * @throws \yii\db\Exception
	 */
	private function linkData()
	{
        $data = $this->owner->{$this->attribute};
        if($data[0] == ",") {
            $data = substr($data,1,strlen($data) + 10);
        }
        if(strlen($data) == 0){return false;}
        $data = explode($this->delimitr,$data);
        if(!is_array($data)){return false;}
        if(!count($data)){return false;}

        $data = array_unique($data);

        $elements = File::find()->where(['IN', File::primaryKey()[0], $data])->indexBy('id')->all();
        $data_sort = [];

        if($data) {
			$i = 0;
			foreach( $data as $d ) {
				$element = $elements[ $d ];
				$i++;
				$data_sort[ $element->id ] = $i;
				$this->owner->link( $this->relation_name, $element );

				$sql = $this->one_table_column . "=" . $this->owner->{$this->owner->primaryKey()[0]} . " AND " . $this->two_table_column . "=" . $element->id;
				Yii::$app->db->createCommand()->update( $this->via_table_name, [ 'sort' => $i ], $sql )->execute();
			}
		}
    }

}