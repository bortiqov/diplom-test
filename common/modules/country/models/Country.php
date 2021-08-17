<?php

namespace common\modules\country\models;

use common\modules\organization\models\Organization;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Organization[] $organizations
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
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
     * Gets query for [[Organisations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organization::class, ['country_id' => 'id']);
    }


    public static function getDropDownList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name.'  . \Yii::$app->language);
    }

    public function getPrettyName() {
        return $this->name[\Yii::$app->language];
    }
}
