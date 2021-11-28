<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "route".
 *
 * @property int $id
 * @property int|null $position
 * @property int|null $group_number
 * @property int|null $point_id
 * @property int|null $service_id
 *
 * @property Point $point
 * @property Service $service
 */
class Route extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position', 'group_number', 'point_id', 'service_id'], 'default', 'value' => null],
            [['position', 'group_number', 'point_id', 'service_id'], 'integer'],
            [['point_id'], 'exist', 'skipOnError' => true, 'targetClass' => Point::className(), 'targetAttribute' => ['point_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
            'group_number' => 'Group Number',
            'point_id' => 'Point ID',
            'service_id' => 'Service ID',
        ];
    }

    /**
     * Gets query for [[Point]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoint()
    {
        return $this->hasOne(Point::className(), ['id' => 'point_id']);
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    public static function getPointList()
    {
        return ArrayHelper::map(Point::find()->all(), 'id', 'name');
    }

    public static function getServiceList()
    {
        return ArrayHelper::map(Service::find()->all(), 'id', 'name');
    }
}
