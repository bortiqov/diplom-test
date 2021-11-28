<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "point".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $lat
 * @property float|null $lon
 *
 * @property Route[] $routes
 */
class Point extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'point';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lat', 'lon'], 'number'],
            [['name'], 'string', 'max' => 255],
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
            'lat' => 'Lat',
            'lon' => 'Lon',
        ];
    }

    /**
     * Gets query for [[Routes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoutes()
    {
        return $this->hasMany(Route::className(), ['point_id' => 'id']);
    }
}
