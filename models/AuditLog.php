<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "audit_log".
 *
 * @property int $id
 * @property string $table_name
 * @property int $row_id
 * @property string $action
 * @property string|null $changed_data
 * @property string|null $created_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 */
class AuditLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['table_name', 'row_id', 'action'], 'required'],
            [['row_id', 'created_by'], 'integer'],
            [['action'], 'string'],
            [['changed_data', 'created_at'], 'safe'],
            [['table_name'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Table Name',
            'row_id' => 'Row ID',
            'action' => 'Action',
            'changed_data' => 'Changed Data',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}
