<?php

namespace common\modules\country\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "district_uz".
 *
 * @property int $id
 * @property int|null $region_id
 * @property string|null $name
 * @property int|null $status
 * @property int|null $top
 *
 * @property Region $region
 * @property Quarter[] $quarterUzs
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'district_uz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id', 'status', 'top'], 'default', 'value' => null],
            [['region_id', 'status', 'top'], 'integer'],
            [['name'], 'safe'],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'name' => 'Name',
            'status' => 'Status',
            'top' => 'Top',
        ];
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * Gets query for [[QuarterUzs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuarterUzs()
    {
        return $this->hasMany(Quarter::className(), ['district_id' => 'id']);
    }


    public static function getDropdownList($region_id = null)
    {
        if ($region_id){
            return self::find()
                ->select("id, (name->>'". Yii::$app->language ."') as name")
                ->asArray()
                ->andWhere(['region_id' => $region_id])
                ->all();
        }

        return ArrayHelper::map(static::find()->all(), 'id', 'name.'  . \Yii::$app->language);

    }
}
