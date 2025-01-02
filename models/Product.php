<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
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
 * @property string $unit
 * @property float $price
 * @property float $cost_price
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Category $category
 * @property Factory[] $factories
 * @property FactoryProduct[] $factoryProducts
 * @property ReportProduct[] $reportProducts
 * @property Report[] $reports
 * @property StorageProduct[] $storageProducts
 * @property Storage[] $storages
 * @property User $createdBy
 * @property User $updatedBy
 */
class Product extends ActiveRecord
{
    public $factoryIds;

    public function behaviors()
    {
        return [
            BlameableBehavior::class,
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
            [['category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'unit'], 'required'],
            [['price', 'cost_price'], 'number'],
            [['unit'], 'string'],
            [['created_at', 'updated_at', 'factoryIds'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']]
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
            'cost_price' => 'Себестоимость',
            'unit' => 'Ед. изм.',
            'parent_id' => 'Родитель',
            'name' => 'Наименование',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'factoryIds' => 'Заводы',
            'created_by' => 'Создал',
            'updated_by' => 'Изменил'
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

    public function getReportProducts()
    {
        return $this->hasMany(ReportProduct::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Reports]].
     *
     * @return ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::class, ['id' => 'report_id'])->viaTable('report_product', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[StorageProducts]].
     *
     * @return ActiveQuery
     */
    public function getStorageProducts()
    {
        return $this->hasMany(StorageProduct::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Storages]].
     *
     * @return ActiveQuery
     */
    public function getStorages()
    {
        return $this->hasMany(Storage::class, ['id' => 'storage_id'])->viaTable('storage_product', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
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

    public static function activeItems()
    {
        return self::find()->where(['status' => 1])->all();
    }
}
