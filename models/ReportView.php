<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "report_view".
 *
 * @property int $id
 * @property int $factory_id
 * @property string $date
 * @property float $cash_amount
 * @property float $transfer_amount
 * @property float $expense
 * @property string|null $expense_description
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property float $income
 * @property float $cost_price
 * @property float $profit
 * @property float $sht
 * @property float $kg
 *
 * @property Factory $factory
 * @property Plan $plan
 * @property Product[] $products
 * @property ReportProduct[] $reportProducts
 * @property User $createdBy
 * @property User $updatedBy
 */
class ReportView extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_view';
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
            [['id', 'factory_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['factory_id', 'date', 'created_at', 'updated_at'], 'required'],
            [['cash_amount', 'transfer_amount', 'expense', 'income', 'cost_price', 'profit', 'sht', 'kg'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['date', 'expense_description'], 'string', 'max' => 255],
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
            'date_range' => 'Период',
            'cash_amount' => 'Наличные',
            'transfer_amount' => 'Перечисление',
            'expense' => 'Расходы',
            'expense_description' => 'Описание расхода',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'income' => 'Приход',
            'cost_price' => 'Пр. товара на сумму',
            'profit' => 'Прибыль',
            'sht' => 'Реал. шт',
            'kg' => 'Реал. кг',
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
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('report_product', ['report_id' => 'id']);
    }

    /**
     * Gets query for [[ReportProducts]].
     *
     * @return ActiveQuery
     */
    public function getReportProducts()
    {
        return $this->hasMany(ReportProduct::class, ['report_id' => 'id']);
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
            ->andOnCondition(['DATE_FORMAT(:reportDate, "%Y-%m")' => new Expression('plan.month')])
            ->addParams([':reportDate' => $this->date]);
    }
}
