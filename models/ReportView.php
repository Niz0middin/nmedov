<?php

namespace app\models;

use Yii;

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
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 * @property float|null $income
 * @property float|null $cost_price
 * @property float|null $profit
 * @property float|null $sht
 * @property float|null $kg
 */
class ReportView extends \yii\db\ActiveRecord
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
            [['id', 'factory_id', 'status'], 'integer'],
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
            'cash_amount' => 'По наличными',
            'transfer_amount' => 'По перечислению',
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
}
