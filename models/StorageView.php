<?php

namespace app\models;

use Yii;

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
 * @property float|null $income
 * @property float|null $cost_price
 * @property float|null $profit
 * @property float|null $sht
 * @property float|null $kg
 */
class StorageView extends \yii\db\ActiveRecord
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
            [['income', 'cost_price', 'profit', 'sht', 'kg'], 'number'],
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
            'income' => 'Приход',
            'cost_price' => 'Пр. товара на сумму',
            'profit' => 'Прибыль',
            'sht' => 'Реал. шт',
            'kg' => 'Реал. кг',
        ];
    }
}
