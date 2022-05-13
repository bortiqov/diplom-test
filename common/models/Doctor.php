<?php

namespace common\models;

use common\modules\file\models\File;
use Yii;

/**
 * This is the model class for table "doctor".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $lavozim
 * @property string|null $bio
 * @property int|null $logo_id
 * @property int|null $status
 *
 * @property File $logo
 */
class Doctor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['logo_id', 'status'], 'default', 'value' => null],
            [['logo_id', 'status'], 'integer'],
            [['first_name', 'last_name', 'lavozim', 'bio'], 'string', 'max' => 255],
            [['logo_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['logo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'lavozim' => 'Lavozim',
            'bio' => 'Bio',
            'logo_id' => 'Logo ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Logo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogo()
    {
        return $this->hasOne(File::className(), ['id' => 'logo_id']);
    }
}
