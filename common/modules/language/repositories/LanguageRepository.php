<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package tourline
 */

namespace common\modules\language\repositories;


use common\components\RepositoryInterface;
use common\modules\language\models\Language;

class LanguageRepository implements RepositoryInterface
{

    public function getById(int $id) : Language {
        return Language::findOne($id);
    }

    public function getAll() : array {
        return Language::find()->all();
    }

}