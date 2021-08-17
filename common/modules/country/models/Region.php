<?php

namespace common\modules\country\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "region_uz".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property int|null $top
 *
 * @property District[] $districtUzs
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region_uz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
            [['status', 'top'], 'default', 'value' => null],
            [['status', 'top'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'top' => 'Top',
        ];
    }

    /**
     * Gets query for [[DistrictUzs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrictUzs()
    {
        return $this->hasMany(District::className(), ['region_id' => 'id']);
    }

    public static function getDropDownList()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'name.'  . \Yii::$app->language);
    }

    public function getPrettyName() {
        return $this->name[\Yii::$app->language];
    }

    public static function getSubRegionList($country_id)
    {
        return self::find()
            ->select("id, (name->>'". Yii::$app->language ."') as name")
            ->asArray()
            ->andWhere(['country_id' => $country_id])
            ->all();
    }
}
