<?php

namespace common\modules\pages\models;


use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
//Системные
use jakharbek\core\behaviors\DateTimeBehavior;
use jakharbek\core\behaviors\UserBehavior;
//Файлы
use jakharbek\filemanager\behaviors\FileModelBehavior;
use common\modules\filemanager\models\Files;
//Пользовтели
use jakharbek\users\models\Users;
//Категории
use jakharbek\categories\behaviors\CategoryModelBehavior;
use jakharbek\categories\models\Categories;
//Теги
use jakharbek\tags\behaviors\TagsModelBehavior;
use jakharbek\tags\models\Tags;
//Темы
use jakharbek\topics\behaviors\TopicModelBehavior;
use jakharbek\topics\models\Topics;
//Видео
use common\modules\videos\models\Videos;
/**
 * This is the model class for table "pagesimages".
 *
 * @property int $page_id
 * @property int $file_id
 * @property int $sort
 *
 * @property Files $file
 * @property Pages $page
 */
class Pagesimages extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pagesimages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'file_id'], 'required'],
            [['page_id', 'file_id', 'sort'], 'default', 'value' => null],
            [['page_id', 'file_id', 'sort'], 'integer'],
            [['title', 'description'], 'string'],
            [['page_id', 'file_id'], 'unique', 'targetAttribute' => ['page_id', 'file_id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::class, 'targetAttribute' => ['file_id' => 'file_id']],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::class, 'targetAttribute' => ['page_id' => 'page_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'page_id' => 'Page ID',
            'file_id' => 'File ID',
            'sort' => 'Sort',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::class, ['file_id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Pages::class, ['page_id' => 'page_id'])->inverseOf('pagesimages');
    }


}
