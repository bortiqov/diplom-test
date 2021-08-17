<?php

namespace common\modules\language\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\language\models\Language]].
 *
 * @see \common\modules\language\models\Language
 */
class LanguageQuery extends \yii\db\ActiveQuery
{

    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    public function all($db = null)
    {
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }

    public function code($code = null)
    {
        return parent::where(['code' => $code]);
    }

}
