<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $status
 */
class Partner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'safe'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'description',
            'title',
            'status'
        ];
    }
}
