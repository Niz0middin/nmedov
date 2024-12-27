<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int $factory_id
 * @property int $date
 * @property double $cash_amount
 * @property double $transfer_amount
 * @property double $expense
 * @property string|null $expense_description
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Factory $factory
 * @property Plan $plan
 * @property Product[] $products
 * @property ReportProduct[] $reportProducts
 */
class Report extends ActiveRecord
{
    public $reportProductsData;

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
        return 'report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['factory_id', 'date'], 'required'],
            [['factory_id', 'status'], 'integer'],
            [['expense', 'cash_amount', 'transfer_amount'], 'number'],
            [['created_at', 'updated_at', 'expense_description'], 'safe'],
            [['date', 'factory_id'], 'unique', 'targetAttribute' => ['date', 'factory_id']],
            [['factory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Factory::class, 'targetAttribute' => ['factory_id' => 'id']],
            [['reportProductsData'], 'safe'],
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
            'cash_amount' => 'Приход наличных средств',
            'transfer_amount' => 'Приход по перечислению',
            'expense' => 'Расходы',
            'expense_description' => 'Комментарий к расходам',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
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

    public function getPlan()
    {
        return $this->hasOne(Plan::class, ['factory_id' => 'factory_id'])
            ->andOnCondition(['DATE_FORMAT(:reportDate, "%Y-%m")' => new Expression('plan.month')])
            ->addParams([':reportDate' => $this->date]);
    }
}
