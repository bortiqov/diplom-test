<?php

namespace common\modules\translation\models;

use common\modules\language\components\QueryBehavior;
use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
/**
 * This is the ActiveQuery class for [[SourceMessage]].
 *
 * @see SourceMessage
 */
class SourceMessageQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            'lang' => [
                'class' => QueryBehavior::class,
                'alias' => SourceMessage::tableName()
            ],
        ];
    }
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SourceMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SourceMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    public function statuses($status = null){
        if($status == SourceMessageQuery::STATUS_ACTIVE):
            return Yii::t('main','Active');
        else:
            return Yii::t('main','Deactive');
        endif;
    }
}
