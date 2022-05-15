<?php

namespace common\models;

use common\modules\file\models\File;
use Yii;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Route[] $routes
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'safe'],
            [['icon'], 'integer'],
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
        ];
    }

    /**
     * Gets query for [[Routes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoutes()
    {
        return $this->hasMany(Route::className(), ['service_id' => 'id']);
    }

    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'icon']);
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'name',
            'file'
        ];
    }
}
