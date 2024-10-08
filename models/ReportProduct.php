<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "report_product".
 *
 * @property int $id
 * @property int $report_id
 * @property int $product_id
 * @property int $amount
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Product $product
 * @property Report $report
 */
class ReportProduct extends \yii\db\ActiveRecord
{
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
            [['created_at', 'updated_at'], 'safe'],
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
            'id' => 'ID',
            'report_id' => 'Отчет',
            'product_id' => 'Продукт',
            'amount' => 'Количество',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
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
     * Gets query for [[Report]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReport()
    {
        return $this->hasOne(Report::class, ['id' => 'report_id']);
    }
}
