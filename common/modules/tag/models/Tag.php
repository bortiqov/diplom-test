<?php

namespace common\modules\tag\models;

use common\modules\language\components\Lang;
use common\modules\post\models\Post;
use common\modules\post\models\PostTags;
use common\modules\post\repositories\PostRepository;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class Tag
 * @package common\modules\tag\models
 */
class Tag extends ActiveRecord
{
    /**
     * Tag constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'tag';
    }


    /**
     * @param $name
     * @param $lang
     * @return Tag
     */
    public static function create($name){
        $tag = new static();
        $tag->name = $name;
        $tag->save();
        return $tag;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
//    public function attributeLabels()
//    {
//        return [
//            'id' => Yii::t('main', 'ID'),
////            'lang' => Yii::t('main', 'Lang'),
//            'name' => Yii::t('main', 'Name'),
//        ];
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTags::class, ['tag_id' => 'id']);
    }

    public function getPosts()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])->via('postTags');
    }

    public function getLink() {
        return \Yii::$app->urlManager->createUrl(['news/tag', 'name' => $this->name]);
    }
}
