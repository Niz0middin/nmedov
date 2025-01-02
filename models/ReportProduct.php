<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "report_product".
 *
 * @property int $report_id
 * @property int $product_id
 * @property float $price
 * @property float $cost_price
 * @property int $amount
 *
 * @property Product $product
 * @property Report $report
 */
class ReportProduct extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_id', 'product_id', 'amount'], 'required'],
            [['report_id', 'product_id', 'amount'], 'integer'],
            [['price', 'cost_price'], 'number'],
            [['report_id', 'product_id'], 'unique', 'targetAttribute' => ['report_id', 'product_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['report_id'], 'exist', 'skipOnError' => true, 'targetClass' => Report::class, 'targetAttribute' => ['report_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'report_id' => 'Отчет',
            'product_id' => 'Продукт',
            'price' => 'Цена',
            'cost_price' => 'Себестоимость',
            'amount' => 'Количество'
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Report]].
     *
     * @return ActiveQuery
     */
    public function getReport()
    {
        return $this->hasOne(Report::class, ['id' => 'report_id']);
    }
}
