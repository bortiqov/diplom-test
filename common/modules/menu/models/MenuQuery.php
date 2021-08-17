<?php

namespace common\modules\menu\models;

use common\modules\language\components\Lang;
use common\modules\language\components\QueryBehavior;
use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;

/**
 * This is the ActiveQuery class for [[Menu]].
 *
 * @see Menu
 */
class MenuQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return Menu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Menu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    public function statuses($status = null)
    {
        if ($status == MenuQuery::STATUS_ACTIVE):
            return Yii::t('app', 'Active');
        else:
            return Yii::t('app', 'Deactive');
        endif;
    }

    public function types()
    {
        $types[] = "Frontend";
        $types[] = "Backend";
        return $types;
    }

    public function alias($alias = null)
    {
        return $this->where(['alias' => $alias])->one();
    }
}
