<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $factory_id
 * @property string $month
 * @property string $start_date
 * @property string $end_date
 * @property string $description
 * @property string|null $reason
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Factory $factory
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['factory_id', 'month', 'start_date', 'end_date', 'description', 'created_at', 'updated_at'], 'required'],
            [['factory_id', 'status'], 'integer'],
            [['description', 'reason'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['month', 'start_date', 'end_date'], 'string', 'max' => 255],
            [['factory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Factory::class, 'targetAttribute' => ['factory_id' => 'id']],
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
            'month' => 'Месяц',
            'start_date' => 'С',
            'end_date' => 'До',
            'description' => 'Описание',
            'reason' => 'Причина отказа',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    /**
     * Gets query for [[Factory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }
}
