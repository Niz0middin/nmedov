<?php

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "factory".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property FactoryProduct[] $factoryProducts
 * @property Plan[] $plans
 * @property Product[] $products
 * @property Report[] $reports
 * @property Storage[] $storages
 * @property Task[] $tasks
 * @property User $createdBy
 * @property User $updatedBy
 */
class Factory extends ActiveRecord
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
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'factory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Наименование',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'created_by' => 'Создал',
            'updated_by' => 'Изменил'
        ];
    }

    /**
     * Gets query for [[FactoryProducts]].
     *
     * @return ActiveQuery
     */
    public function getFactoryProducts()
    {
        return $this->hasMany(FactoryProduct::class, ['factory_id' => 'id']);
    }

    /**
     * Gets query for [[Plans]].
     *
     * @return ActiveQuery
     */
    public function getPlans()
    {
        return $this->hasMany(Plan::class, ['factory_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])
            ->viaTable('factory_product', ['factory_id' => 'id']);
    }

    /**
     * Gets query for [[Reports]].
     *
     * @return ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::class, ['factory_id' => 'id']);
    }

    /**
     * Gets query for [[Storages]].
     *
     * @return ActiveQuery
     */
    public function getStorages()
    {
        return $this->hasMany(Storage::class, ['factory_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['factory_id' => 'id']);
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

    public static function activeItems()
    {
        return self::find()->where(['status' => 1])->all();
    }
}
