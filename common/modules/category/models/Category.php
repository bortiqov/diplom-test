<?php

namespace common\modules\category\models;

use common\behaviors\SlugBehavior;
use common\modules\product\models\Product;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property int|null $icon
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $parent_id
 */
class Category extends \yii\db\ActiveRecord
{
    const ORGANIZATION_SLUG = 'organizations';

    const PRODUCT_SLUG = 'shop-category';

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'slugBehavior' => [
                'class' => SlugBehavior::class,
                'attribute_title' => 'name'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
            ['slug', 'string'],
            ['slug', 'unique', 'targetClass' => static::class],
            [['icon', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['parent_id'], 'default', 'value' => null],
            [['icon', 'created_at', 'updated_at', 'parent_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon',
            'slug' => 'Slug',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'parent_id' => 'Parent Id',
        ];
    }

    public function getParent()
    {
        return $this->hasOne(static::class, ['id' => 'parent_id']);
    }

    public function getChildren()
    {
        return $this->hasMany(static::class, ['parent_id' => 'id']);
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['product_category_id' => 'id']);
    }

    /**
     * @param null $id
     * @param false $onlyParents
     * @return array
     */
    public static function getDropdownList($id = null, $onlyParents = false)
    {
        if ($id) {
            return ArrayHelper::map(static::find()->andFilterWhere(['parent_id' => $id])->all(), 'id', 'name.' . Yii::$app->language);
        } elseif ($onlyParents) {
            return ArrayHelper::map(static::find()->andWhere(['parent_id' => 0])->all(), 'id', 'name.' . Yii::$app->language);
        }

        return ArrayHelper::map(static::find()->all(), 'id', 'name.' . Yii::$app->language);
    }

    public static function getSubCategoryDropDownList($cat_id)
    {
        return self::find()
            ->select("id, (name->>'ru') as name")
            ->asArray()
            ->andWhere(['parent_id' => $cat_id])
            ->all();
    }

    public function fields()
    {
        return [
            'id',
            'name' => function ($model) {
                return array_key_exists(\Yii::$app->language,
                    $model->name) ? $model->name[\Yii::$app->language] : $model->name['ru'];
            },
            'icon',
            'slug',
            'created_at',
            'updated_at',
            'parent_id',
            'children',
        ];
    }

    public function extraFields()
    {
        return [
            'products' => function () {
                return $this->products;
            },
        ];
    }
}
