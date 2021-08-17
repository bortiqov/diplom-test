<?php
namespace common\modules\language\components;

use Yii;
use yii\base\Component;
use common\modules\language\models\Language;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Lang extends Component{
    /*
     *
     * @const для запрос установки языка для хендлера
     *        если возникнут коллизии можно сдесь изменить
     *
     *  */
    const SET_LANG_REQUEST = "setLang";
    /*
    *
    * @const для название сесси если возникнут коллизи с сессиами можно сдесь
     *       изменить имя сесси
    *
    *  */
    const SESSION_LANG_NAME = 'lang_data';
   /*
    * Lang hash ключ в запросе если возникнут коллизи можно изменить
    * это значение сдесь
    */
    const LANG_HASH_GET_NAME = 'lang_hash';
    /*
        * @method - для устновки в событие перед загрузкой приложение
        *           а имено для запроса
        * */
    public static function onRequestHandler()
    {
        static::setLangRequestHandler();
    }
    public static function setLangRequestHandler()
    {

        $session = $session = Yii::$app->session;
        $currentLang = null;

        if(Yii::$app->request->get(self::SET_LANG_REQUEST) || Yii::$app->request->post(self::SET_LANG_REQUEST))
        {
            $currentLang = Yii::$app->request->{Yii::$app->request->method}(self::SET_LANG_REQUEST);
            if($currentLang = Language::find()->code($currentLang)->one())
            {
                $session->set(self::SESSION_LANG_NAME,$currentLang->code);
            }
        }

        if($session->has(self::SESSION_LANG_NAME))
        {
            $currentLang = $session->get(self::SESSION_LANG_NAME);
            Yii::$app->language = $currentLang;
        }

    }
    /*
     *
     * Получает ID языка по Code или можно получить текушей если нечего не указывать
     *
     */
    public static function getLangId($code = null){
        if($code == null){
            return \common\modules\language\models\Language::find()->code(Yii::$app->language)->one()->id;
        }else{
            return \common\modules\language\models\Language::find()->code($code)->one()->id;
        }
    }
    /*
     * В основном приватный метод который используеться в одной из логик системы
     * принимает он модел ActiveRecord
     * возврашает он массив языков который нужно перевести
     */
    public static function withoutTranslate(ActiveRecord $model,$withoutlangs = true,$index_by = 'primaryKey'){
        $langs_has = [];
        $langs_query = [];
        if($index_by == 'primaryKey'):
            $index_by_t = $model::primaryKey()[0];
        else:
            $index_by_t = $index_by;
        endif;
        $translates = $model::find()->select(['lang','lang_hash',$model::primaryKey()[0]])->where(['lang_hash' => $model->lang_hash])->indexBy($index_by_t)->asArray()->all();

        foreach ($translates as $translate):
            $langs_has[$translate['lang']] = Language::findOne($translate['lang']);
            $langs_query[] = $translate['lang'];
        endforeach;

        $langs = Language::find()->where(['not in','id',$langs_query])->indexBy('id')->all();

        if($withoutlangs)
        {
            return $langs;
        }
        else{
            return $translates;
        }
    }
}