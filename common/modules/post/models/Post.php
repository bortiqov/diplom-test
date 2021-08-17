<?php

namespace common\modules\post\models;

use common\models\Image;
use common\modules\file\behaviors\FileModelBehavior;
use common\modules\file\behaviors\InputModelBehavior;
use common\modules\file\models\File;
use common\modules\user\models\User;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $author
 * @property string|null $title
 * @property string|null $description
 * @property string|null $slug
 * @property string|null $photo
 * @property int|null $type
 * @property int $created_at
 * @property int $updated_at
 * @property int $published_at
 * @property int|null $top
 * @property int|null $viewed
 * @property int|null $status
 * @property string|null $anons
 * @property int|null $short_link
 *
 * @property User $author0
 */
class Post extends \yii\db\ActiveRecord
{
    const TYPE_DEFAULT = 1;

    const TYPE_VEBINAR = 2;

    const STATUS_PENDING = 3;


    /**
     * @var
     */
    private $_filesdata;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
//            Import purposes end
            'author' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'author',
                ],
                'value' => function ($event) {
                    if (\Yii::$app->controller->id != 'calculate') {
                        if (\Yii::$app->user->isGuest) {
                            $this->status = self::STATUS_PENDING;
                        }

                        return Yii::$app->user->identity->getId();
                    } else {
                        return $this->author;
                    }
                },
            ],
//            Import purposes start
            'date_filter' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at', 'published_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'file_manager_model' => [
                'class' => FileModelBehavior::className(),
                'attribute' => 'filesdata',
                'relation_name' => 'files',
                'delimitr' => ',',
                'via_table_name' => 'post_img',
                'via_table_relation' => 'postimgfiles',
                'one_table_column' => 'post_id',
                'two_table_column' => 'file_id'
            ],
            'input_filemanager' => [
                'class' => InputModelBehavior::className(),
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'photo'], 'required'],
            [['author', 'type', 'created_at', 'updated_at', 'published_at', 'top', 'viewed', 'status', 'short_link'], 'default', 'value' => null],
            [['author', 'type', 'created_at', 'updated_at', 'top', 'viewed', 'status', 'short_link'], 'integer'],
            [['title', 'description'], 'safe'],
            ['viewed', 'default', 'value' => 0],
            [['created_at', 'updated_at', 'author', 'published_at','filesdata'], 'safe'],
            [['anons'], 'string'],
            [['author'], 'default', 'value' => null],
            [['slug', 'photo'], 'string', 'max' => 255],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'title' => 'Title',
            'description' => 'Description',
            'slug' => 'Slug',
            'photo' => 'Photo',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'published_at' => 'Published At',
            'top' => 'Top',
            'viewed' => 'Viewed',
            'status' => 'Status',
            'anons' => 'Anons',
            'short_link' => 'Short Link',
        ];
    }

    /**
     * Gets query for [[Author0]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\post\models\query\UserQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\post\models\query\PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\post\models\query\PostQuery(get_called_class());
    }

    public function getPicture()
    {
        return $this->hasOne(File::className(), ['id' => 'photo']);
    }

    public function getPrettyDate()
    {
        return Yii::$app->formatter->asDatetime($this->published_at,'dd.MM.YY');
    }

    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'photo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostImgs()
    {
        return $this->hasMany(PostImg::class, ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])->via('postImgs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagesPosters()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])->viaTable('post_img',
            ['post_id' => 'id']);
    }

    public function getLink()
    {
        return \Yii::$app->urlManager->createUrl([
            'post/show',
            'id' => $this->id,
        ]);
    }

    /**
     * @return mixed
     */
    public function getFilesdata()
    {
        return $this->_filesdata;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setFilesdata($value)
    {
        return $this->_filesdata = $value;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->published_at = strtotime($this->published_at);

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function fields()
    {
        return [
            'id',
            'author' => function($model){
                return $model->author0->username;
            },
            'title' => function ($model) {
                return array_key_exists(\Yii::$app->language,
                    $model->title) ? $model->title[\Yii::$app->language] : $model->title['ru'];
            },
            'description' => function ($model) {
                return array_key_exists(\Yii::$app->language,
                    $model->description) ? $model->description[\Yii::$app->language] : $model->description['ru'];
            },
            'main_photo' => function ($model) {
                $image = $model->image;

                if (!$image) {
                    return null;
                }

                return @$image->getImageThumbs();
            },
            'type',
            'created_at' => function($model) {
                return Yii::$app->formatter->asDatetime($model->created_at,'dd.MM.YY');
            },
            'updated_at' => function($model) {
                return Yii::$app->formatter->asDatetime($model->updated_at,'dd.MM.YY');
            },
            'published_at' => function($model){
                return $model->prettyDate;
            },
            'photos' => function ($model) {
                $photo = [];
                foreach ($model->imagesPosters as $imagesPoster) {
                    $photo[] = $imagesPoster->getSrc('medium');
                }
                return $photo;
            },
            'viewed',
        ];
    }
}
