<?php
/**
 * Created by PhpStorm.
 * User: utkir
 * Date: 07.08.2018
 * Time: 19:45
 */

namespace common\modules\tag\forms\post;


use common\modules\post\models\Post;
use yii\base\Model;
use common\modules\tag\models\Tag;
use yii\helpers\ArrayHelper;

class TagsForm extends Model
{
    public $existing = [];
    public $textNew;

    public function __construct(Post $post = null, $config = [])
    {
        if ($post) {
            $this->existing = ArrayHelper::getColumn($post->postTags, 'tag_id');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['existing', 'each', 'rule' => ['integer']],
            ['textNew', 'string'],
            ['existing', 'default', 'value' => []],
        ];
    }

    public function tagsList()
    {
        return ArrayHelper::map(Tag::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function getNewNames()
    {
        return array_filter(array_map('trim', preg_split('#\s*,\s*#i', $this->textNew)));
    }
}