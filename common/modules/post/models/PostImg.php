<?php

namespace common\modules\post\models;

use common\models\Image;
use common\modules\file\models\File;
use Yii;

/**
 * This is the model class for table "post_img".
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $file_id
 * @property int|null $sort
 *
 * @property File $file
 * @property Post $post
 */
class PostImg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_img';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'file_id', 'sort'], 'default', 'value' => null],
            [['post_id', 'file_id', 'sort'], 'integer'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'file_id' => 'File ID',
            'sort' => 'Sort',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\post\models\query\FileQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'file_id']);
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\post\models\query\PostQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\post\models\query\PostImgQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\post\models\query\PostImgQuery(get_called_class());
    }

    public function fields()
    {
        return [
            'id',
            'photo' => function ($model) {
                $image = $model->file;

                if (!$image) {
                    return null;
                }

                return @$image->getThumbnails();
            },
        ];
    }
}
