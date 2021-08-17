<?php


namespace common\modules\pages\models;

use common\behaviors\DateTimeBehavior;
use common\behaviors\SlugBehavior;
use common\modules\file\behaviors\GalleryFileModelBehavior;
use common\modules\file\models\File;
use common\modules\categories\models\Categories;
use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\modules\file\behaviors\FileModelBehavior;
use common\modules\file\behaviors\InputModelBehavior;

/**
 * This is the model class for table "pages".
 *
 * @property int $id Идентификатор
 * @property string $title Зоголовок
 * @property string $subtitle Под заголовок поста
 * @property string $description Описание
 * @property string $content Контент
 * @property string $slug Слаг
 * @property string $template Шаблон
 * @property int $sort Сортировка
 * @property int $date_update Дата побновление
 * @property int $date_create Дата добавление
 * @property int $date_publish Дата публикации
 * @property int $status Статус
 * @property int $user_id Пользователь
 */
class Pages extends \yii\db\ActiveRecord
{
    const DESCRIPTION = "Страницы";

    const SCENARIO_SEARCH = "search";
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TOPIC_TYPE = 200;

    private $_imagespostersdata;
    public $files;

    /**
     * @return array
     */
    public function behaviors()
        {
        return ArrayHelper::merge(parent::behaviors(),[
            'date_filter' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
            ],
            'date_publish_date' => [
                'class' => DateTimeBehavior::class,
                'attribute' => 'date_publish', //атрибут модели, который будем менять
                'format'         => 'dd.MM.yyyy HH:mm',   //формат вывода даты для пользователя
                'disableScenarios' => [self::SCENARIO_SEARCH],
                'default' => 'today'
            ],
            'slug' => [
                'class' => SlugBehavior::class,
                'attribute' => 'slug',
                'attribute_title'=> 'title',
            ],
//            'file_manager_model_images' => [
//                'class' => FileModelBehavior::class,
//                'attribute' => 'imagespostersdata',
//                'relation_name' => 'images',
//                'delimitr' => ',',
//                'via_table_name' => 'pagesimages',
//                'via_table_relation' => 'pagesimages',
//                'one_table_column' => 'page_id',
//                'two_table_column' => 'file_id'
//            ],
        ]); // TODO: Change the autogenerated stub

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @return PagesQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new PagesQuery(get_called_class());
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'date_update', 'date_create', 'date_publish', 'status'], 'default', 'value' => null],
            [['title', 'subtitle', 'template','description', 'content'], 'safe'],
            [['slug'], 'string', 'max' => 600],
            ['title', 'required'],
            [['slug'], 'unique', 'targetAttribute' => ['slug']],
            [['imagespostersdata'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'page_id' => Yii::t('app', 'Page ID'),
            'title' => Yii::t('app', 'Title'),
            'subtitle' => Yii::t('app', 'Subtitle'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'slug' => Yii::t('app', 'Slug'),
            'template' => Yii::t('app', 'Template'),
            'sort' => Yii::t('app', 'Sort'),
            'date_update' => Yii::t('app', 'Date Update'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_publish' => Yii::t('app', 'Date Publish'),
            'status' => Yii::t('app', 'Status'),
            //categories topics tags
            'categories' => Yii::t('app', 'Categories'),
            'images_posters' => Yii::t('app', 'Images'),
        ];
    }


    /**
     * @return mixed
     */
    public function getCategoriesform(){
        return $this->_categoriesform;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setCategoriesform($value){
        return $this->_categoriesform = $value;
    }


    public function getimagespostersdata(){
        return $this->_imagespostersdata;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setimagespostersdata($value){
        return $this->_imagespostersdata = $value;
    }


    public function getIds()
    {
        return $this->hasMany(Categories::class, ['id' => 'id'])->viaTable('pagescategories', ['page_id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagesimages()
    {
        return $this->hasMany(Pagesimages::class, ['page_id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(File::class, ['file_id' => 'file_id'])->viaTable('pagesimages', ['page_id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getImg(){
        if(count($this->images))
        {
            return $this->images[0]->src;
        }

        return File::no_photo();
    }

    /**
     * @return null|static
     */
    public function getImgFile(){
        if(count($this->images))
        {
            return $this->images[0];
        }
        return File::no_photo();
    }
    public function counterUp(){
        $this->updateCounters(['views' => 1]);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getDateTitle(){
        $timestamp = strtotime($this->date_publish);
        return Yii::$app->formatter->asDatetime($timestamp,"php:d F H:m");
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */

    public function viewsUp(){
        $model = $this;
        Yii::$app->tools->viewsUp($this->tableName(),function()use($model){
            $all = $model->translateVersions;
            foreach ($all as $data){
                $data->counterUp();
            }
        });
    }

    public function fields()
    {
        return [
            'id',
            'title' => function ($model) {
                return $model->title[\Yii::$app->language];
            },
            'subtitle' => function ($model) {
                return $model->subtitle[\Yii::$app->language];
            },
            'description' => function ($model) {
                return $model->description[\Yii::$app->language];
            },
            'content' => function ($model) {
                return $model->description[\Yii::$app->language];
            },
            'slug',
        ];
    }

    public static function getStatuses($status = null){
        $data = [
            1 => Yii::t('app','Active'),
            0 => Yii::t('app','Deactive'),
        ];
        if($status === null){
            return $data;
        }else{
            return $data[$status];
        }
    }
}
