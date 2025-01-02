<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "plan".
 *
 * @property int $id
 * @property int $factory_id
 * @property string $month
 * @property float $amount
 * @property float $profit
 * @property int $status
 * @property int $sht_amount
 * @property int $kg_amount
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Factory $factory
 * @property Report[] $reports
 * @property User $createdBy
 * @property User $updatedBy
 */
class Plan extends ActiveRecord
{
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
        return 'plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['factory_id', 'month', 'sht_amount', 'kg_amount'], 'required'],
            [['factory_id', 'status', 'sht_amount', 'kg_amount', 'created_by', 'updated_by'], 'integer'],
            [['amount', 'profit'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['month'], 'string', 'max' => 255],
            [['month', 'factory_id'], 'unique', 'targetAttribute' => ['month', 'factory_id']],
            [['factory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Factory::class, 'targetAttribute' => ['factory_id' => 'id']],
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
            'factory_id' => 'Завод',
            'status' => 'Статус',
            'month' => 'Месяц',
            'amount' => 'Приход',
            'profit' => 'Прибыль',
            'sht_amount' => 'шт',
            'kg_amount' => 'кг',
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

    public function getReports()
    {
        return $this->hasMany(Report::class, ['factory_id' => 'factory_id'])->andOnCondition([
            'DATE_FORMAT(report.date, "%Y-%m")' => $this->month
        ]);
    }

    public function getReportViews()
    {
        return $this->hasMany(ReportView::class, ['factory_id' => 'factory_id'])->andOnCondition([
            'DATE_FORMAT(report_view.date, "%Y-%m")' => $this->month
        ]);
    }

    public function getProducedPercentage()
    {
        // Retrieve the total value of produced products (price * count)
        $totalProduced = (new Query())
            ->select(['SUM((product.price - product.cost_price) * report_product.amount) AS totalProduced'])
            ->from('report_product')
            ->innerJoin('product', 'product.id = report_product.product_id')
            ->innerJoin('report', 'report.id = report_product.report_id')
            ->where(['report.factory_id' => $this->factory_id])
            ->andWhere(['DATE_FORMAT(report.date, "%Y-%m")' => $this->month])
            ->scalar();
        // Retrieve the total expenses for the same reports
        $totalExpenses = (new Query())
            ->select(['SUM(report.expense) AS totalExpenses'])
            ->from('report')
            ->where(['factory_id' => $this->factory_id])
            ->andWhere(['DATE_FORMAT(report.date, "%Y-%m")' => $this->month])
            ->scalar();
        // Subtract expenses from total produced value
        $netProduced = $totalProduced - $totalExpenses;
        // Calculate the percentage of the plan amount produced
        if ($this->amount > 0) {
            return round(($netProduced / ($this->profit)) * 100, 2);
        }
        return 0;
    }
}
