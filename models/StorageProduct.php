<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storage_product".
 *
 * @property int $storage_id
 * @property int $product_id
 * @property float $price
 * @property float $cost_price
 * @property int $amount
 * @property int $remaining_amount
 *
 * @property Product $product
 * @property Storage $storage
 */
class StorageProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storage_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['storage_id', 'product_id', 'price', 'cost_price', 'amount', 'remaining_amount'], 'required'],
            [['storage_id', 'product_id', 'amount', 'remaining_amount'], 'integer'],
            [['price', 'cost_price'], 'number'],
            [['storage_id', 'product_id'], 'unique', 'targetAttribute' => ['storage_id', 'product_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['storage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storage::class, 'targetAttribute' => ['storage_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'storage_id' => 'Storage ID',
            'product_id' => 'Product ID',
            'price' => 'Price',
            'cost_price' => 'Cost Price',
            'amount' => 'Amount',
            'remaining_amount' => 'Remaining Amount',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Storage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStorage()
    {
        return $this->hasOne(Storage::class, ['id' => 'storage_id']);
    }
}
