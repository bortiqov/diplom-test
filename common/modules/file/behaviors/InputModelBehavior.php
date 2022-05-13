<?php

namespace common\modules\file\behaviors;

/**
 *
 * @author Jakhar <javhar_work@mail.ru>
 *
 */

use common\modules\file\models\File;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;


class InputModelBehavior extends AttributeBehavior
{
    /**
     * @var string
     */
    public $delimitr = ",";
    /**
     * @param $attribute
     * @return array|bool|File[]|
     */
    public function allFiles($attribute,$returnActiveQuery = false){

        $data = $this->owner->{$attribute};
        if(strlen($data) == 0){return false;}
        if($data[0] == $this->delimitr)
        {
            $data = substr($data,1);
        }
        if(strlen($data) == 0){return false;}
        $data = explode($this->delimitr,$data);
        if(!is_array($data)){return false;}
        if(!count($data)){return false;}

        $elements = File::find()->where(['in', File::primaryKey()[0], $data]);
        if($returnActiveQuery){return $elements;}
        return $elements->all();
    }

}