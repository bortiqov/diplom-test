<?php

namespace common\modules\menu\models;

use common\modules\post\models\Post;
use Yii;
use yii\caching\TagDependency;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "menu_items".
 *
 * @property int $menu_item_id Идентификатор
 * @property int $menu_id Меню
 * @property string $title Название
 * @property string $url Ссылка
 * @property int $sort Сортировка
 * @property int $menu_item_parent_id Родитель
 *
 * @property Menu $menu
 * @property MenuItems $menuItemParent
 * @property MenuItems[] $menuItems
 */
class MenuItems extends \yii\db\ActiveRecord
{
    const SCENARIO_SEARCH = "search";
    const STATUS_ACTIVE = 1;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'sort', 'menu_item_parent_id'], 'default', 'value' => null],
            [['menu_id', 'sort', 'menu_item_parent_id'], 'integer'],
            [['url'], 'string'],
            [['image_id', 'title'], 'safe'],
            [['icon'], 'string', 'max' => 500],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::class, 'targetAttribute' => ['menu_id' => 'menu_id']],
            [['menu_item_parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItems::class, 'targetAttribute' => ['menu_item_parent_id' => 'menu_item_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_item_id' => 'Menu Item ID',
            'menu_id' => 'Menu ID',
            'title' => Yii::t('app','Title'),
            'url' => Yii::t('app','Url'),
            'sort' => Yii::t('app','Sort'),
            'icon' => Yii::t('app','Icon'),
            'menu_item_parent_id' => 'Menu Item Parent ID',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['menu_id' => 'menu_id'])->orderBy(['sort' => SORT_ASC])->inverseOf('menuItems');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItemParent()
    {
        return $this->hasOne(MenuItems::class, ['menu_item_id' => 'menu_item_parent_id'])->orderBy(['sort' => SORT_ASC])->inverseOf('menuItems');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItems::class, ['menu_item_parent_id' => 'menu_item_id'])->orderBy(['sort' => SORT_ASC])->inverseOf('menuItemParent');
    }


    /**
     * @inheritdoc
     * @return MenuItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuItemsQuery(get_called_class());
    }

    public function fields() {
        return array(
            'title' => function ($model) {
                return array_key_exists(\Yii::$app->language,
                    $model->title) ? $model->title[\Yii::$app->language] : $model->title['ru'];
            },
            'url',
            'sort',
            'icon',
            'menu_item_parent_id',
            'childs' => function($model) {
                return $this->menuItems;
            }
        );
    }

    public function afterFind() {
        if (\Yii::$app->language == 'oz') {
            $this->title = Post::translateToLatin($this->title);
        }

        parent::afterFind();
    }


}
