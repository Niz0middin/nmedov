<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "report".
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
 *
 * @property Factory $factory
 * @property Plan $plan
 * @property Product[] $products
 * @property ReportProduct[] $reportProducts
 * @property User $createdBy
 * @property User $updatedBy
 */
class Report extends ActiveRecord
{
    public $reportProductsData;

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
        return 'report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['factory_id', 'date'], 'required'],
            [['factory_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['expense', 'cash_amount', 'transfer_amount'], 'number'],
            [['created_at', 'updated_at', 'expense_description'], 'safe'],
            [['date', 'factory_id'], 'unique', 'targetAttribute' => ['date', 'factory_id']],
            [['factory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Factory::class, 'targetAttribute' => ['factory_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['reportProductsData'], 'safe']
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
