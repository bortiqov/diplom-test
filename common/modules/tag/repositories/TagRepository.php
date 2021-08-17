<?php
/**
 * Created by PhpStorm.
 * User: utkir
 * Date: 28.05.2018
 * Time: 23:28
 */

namespace common\modules\tag\repositories;

use common\modules\tag\models\Tag;
use RuntimeException;
use DomainException as  NotFoundException;

/**
 * Class TagRepository
 * @package common\modules\tag\repositories
 */
class TagRepository
{
    /**
     * @param $id
     * @return Tag
     */
    public function get($id)
    {
        if(!$tag = Tag::findOne($id)){
            throw new NotFoundException('Tag is Not found');
        }
        return $tag;
    }

    public function findByName($name)
    {
        return Tag::findOne(['name' => $name]);
    }

    /**
     * @param Tag $tag
     */
    public function save(Tag $tag)
    {
        if (!$tag->save()) {
            throw new RuntimeException('Saving error');
        }
    }

    /**
     * @param Tag $tag
     * @throws \Exception
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Tag $tag)
    {
        if(!$tag->delete()){
            throw new RuntimeException('Removing error.');
        }
    }

    /**
     * @return array|Tag[]
     */
    public function getAll() {
        return Tag::find()->all();
    }

}
