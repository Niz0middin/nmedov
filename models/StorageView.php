<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "storage_view".
 *
 * @property int $id
 * @property int $factory_id
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property float $amount
 * @property float $sht
 * @property float $kg
 * @property float $remaining_amount
 * @property float $remaining_sht
 * @property float $remaining_kg
 */
class StorageView extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storage_view';
    }

    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'factory_id', 'created_by', 'updated_by'], 'integer'],
            [['factory_id', 'date', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['amount', 'sht', 'kg', 'remaining_amount', 'remaining_sht', 'remaining_kg'], 'number'],
            [['date'], 'string', 'max' => 255],
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
            'updated_by' => 'Изменил',
            'amount' => 'Сумма товаров',
            'sht' => 'Кол. пр. продукции. шт',
            'kg' => 'Кол. пр. продукции. кг',
            'remaining_amount' => 'Общий остаток продукции',
            'remaining_sht' => 'Общий остаток продукции. шт',
            'remaining_kg' => 'Общий остаток продукции. кг'
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
