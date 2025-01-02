<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "storage".
 *
 * @property int $id
 * @property int $factory_id
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Factory $factory
 * @property Plan $plan
 * @property Product[] $products
 * @property StorageProduct[] $storageProducts
 * @property User $createdBy
 * @property User $updatedBy
 */
class Storage extends ActiveRecord
{
    public $storageProductsData;

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
        return 'storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['factory_id', 'date'], 'required'],
            [['factory_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['date'], 'string', 'max' => 255],
            [['date', 'factory_id'], 'unique', 'targetAttribute' => ['date', 'factory_id']],
            [['factory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Factory::class, 'targetAttribute' => ['factory_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['storageProductsData'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'factory_id' => 'Завод',
            'date' => 'Дата',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'created_by' => 'Создал',
            'updated_by' => 'Изменил'
        ];
    }

    /**
     * Gets query for [[Factory]].
     *
     * @return ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('storage_product', ['storage_id' => 'id']);
    }

    /**
     * Gets query for [[StorageProducts]].
     *
     * @return ActiveQuery
     */
    public function getStorageProducts()
    {
        return $this->hasMany(StorageProduct::class, ['storage_id' => 'id']);
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

    public function getPlan()
    {
        return $this->hasOne(Plan::class, ['factory_id' => 'factory_id'])
            ->andOnCondition(['DATE_FORMAT(:storageDate, "%Y-%m")' => new Expression('plan.month')])
            ->addParams([':storageDate' => $this->date]);
    }
}
