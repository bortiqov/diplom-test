<?php

namespace common\modules\language\widgets;

use Yii;
use common\modules\language\components\Lang;
use yii\base\Widget;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\modules\language\models\Language;
use yii\helpers\Url;

/**
 * @inheritdoc
 * @class
 * Нужно преминят этот виджет для вывода всех языков доступных для перевода
 * данный странице
 */
class LangsWidgets extends Widget
{
    /**
     * @inheritdoc
     * @prop модел который нужнен перевод
     * если модел заполнена то режим стаёт одиночным
     * если не заполнена то множественным
     *
     *
     *
     * @example
     * @archive
     * для архива
     *```
     * echo LangsWidgets::widget();
     * ```
     *
     * @single
     *
     * если у вас по другим параметрам определаетсья запись вы можете изменить параметр запроса
     * переопределив ключ в массиве find_by_request
     *  ```
     *  echo LangsWidgets::widget(['model_db' => $model,'create_url' => '/posts/posts/create/']);
     * ```
     *
     *
     *
     */
    /*
     * Active Record model
     */
    public $model_db;
    private $plural;
    /*
     * @example
     * posts/posts/create/
     */
    public $create_url;
    /*
     * @example
     * http://admin.yoshlartv.loc/posts/posts/update?id=4
     * id = 4
     * id;
     */
    public $find_by_request = 'id';

    public $dont_show = array();

    public function init()
    {
        parent::init();
        if ($this->model_db instanceof ActiveRecord) {
            $this->plural = false;
        } else {
            $this->plural = true;
        }
    }

    public function run()
    {
        $model_db = $this->model_db;
        $dependency = [
            'class' => 'yii\caching\DbDependency',
            'sql' => 'SELECT COUNT(*) FROM [[language]]',
        ];

        $langs = Language::find()->active()->all();
        $li_class = null;
        $request_get = Yii::$app->request->get();

        if (!$this->plural) {
            $no_translations = Lang::withoutTranslate($this->model_db);
            $translations = Lang::withoutTranslate($this->model_db, false, 'lang');
        }

        if (array_key_exists(Lang::SET_LANG_REQUEST, $request_get)) {
            unset($request_get[Lang::SET_LANG_REQUEST]);
        }

        $lang_params = ArrayHelper::merge([Yii::$app->request->pathInfo], $request_get);
        $id_cache = ArrayHelper::merge($lang_params, ['language']);

        foreach ($langs as $lang):
            if (in_array($lang->code, $this->dont_show)) {
                continue;
            }
            $li_class = [];
            $classes = [];

            if ($lang->code == Yii::$app->language):
                $li_class[] = "btn-success";
            endif;
            if (!$this->plural):
                if (array_key_exists($lang->id, $no_translations)) {
                    $li_class[] = 'no-translate';
                    $request_get[Lang::LANG_HASH_GET_NAME] = $this->model_db->lang_hash;
                }
                if (array_key_exists($lang->id, $translations)) {
                    $request_get[$this->find_by_request] = $translations[$lang->id][$model_db::primaryKey()[0]];
                }
            endif;

            $request_get[Lang::SET_LANG_REQUEST] = $lang->code;

            $link = Url::current($request_get);

            if ($this->create_url):
                if (array_key_exists($lang->id, $no_translations)) {
                    $link = Url::to(ArrayHelper::merge([$this->create_url], $request_get));
                }
            endif;

            if (count($li_class)):
                $classes = implode(' ', $li_class);
            endif;

            echo '<a href="' . $link . '" class="ml-1">';
            if (is_array($classes)) {
                echo '<div class="btn btn-outline-success ';
                foreach ($classes as $class) {
                    echo $class . " ";
                }
                echo '">';
            } else {
                echo '<div class="btn ' . $classes . '">';
            }
            echo $lang->name;
            echo "</div>";
            echo '</a>';

        endforeach;

    }
}