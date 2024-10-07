<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string $name
 * @property float|null $price
 * @property string $unit
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 * @property Factory[] $factories
 * @property FactoryProduct[] $factoryProducts
 */
class Product extends ActiveRecord
{
    public $factoryIds;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => date('Y-m-d H:i:s')
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'status'], 'integer'],
            [['name', 'unit'], 'required'],
            [['price'], 'number'],
            [['unit'], 'string'],
            [['created_at', 'updated_at', 'factoryIds'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'factory_id' => 'Завод',
            'price' => 'Цена',
            'unit' => 'Ед. изм.',
            'parent_id' => 'Родитель',
            'name' => 'Наименование',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'factoryIds' => 'Заводы',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Factories]].
     *
     * @return ActiveQuery
     */
    public function getFactories()
    {
        return $this->hasMany(Factory::class, ['id' => 'factory_id'])->viaTable('factory_product', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[FactoryProducts]].
     *
     * @return ActiveQuery
     */
    public function getFactoryProducts()
    {
        return $this->hasMany(FactoryProduct::class, ['product_id' => 'id']);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->factoryIds = ArrayHelper::getColumn($this->factories, 'id');
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        FactoryProduct::deleteAll(['product_id' => $this->id]);
        if (is_array($this->factoryIds) && !empty($this->factoryIds)) {
            foreach ($this->factoryIds as $factoryId) {
                $factoryProduct = new FactoryProduct();
                $factoryProduct->product_id = $this->id;
                $factoryProduct->factory_id = $factoryId;
                $factoryProduct->save();
            }
        }
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        FactoryProduct::deleteAll(['product_id' => $this->id]);
        return true;
    }
}
