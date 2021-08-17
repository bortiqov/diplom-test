<?php

namespace common\modules\settings\models;

use common\modules\language\components\QueryBehavior;
use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
/**
 * This is the ActiveQuery class for [[Settings]].
 *
 * @see Settings
 */
class SettingsQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            'lang' => [
                'class' => QueryBehavior::class,
                'alias' => Settings::tableName()
            ],
        ];
    }
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return Settings[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Settings|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    public function statuses($status = null){
        if($status == SettingsQuery::STATUS_ACTIVE):
            return Yii::t('app','Active');
        else:
            return Yii::t('app','Deactive');
        endif;
    }

    public function types(){
        return [
            1 => Yii::t('app','site'),
            2 => Yii::t('app','header'),
            3 => Yii::t('app','footer'),
            7 => Yii::t('app','social'),
            10 => Yii::t('app','banner'),
        ];
    }
    public function inputs(){
        return [
            1 => 'input',
            2 => 'select',
            5 => 'textarea',
            6 => 'file'
        ];
    }
    public function type($type = 1){
        $this->where(['type' => $type]);
        $this->lang();
        return $this;
    }
    public function slug($slug = null){
        $this->where(['slug' => $slug]);
        $this->lang();
        return $this;
    }
}
