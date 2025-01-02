<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%plan}}`.
 */
class m241012_204836_create_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%plan}}', [
            'id' => $this->primaryKey(),
            'factory_id' => $this->integer()->notNull(),
            'month' => $this->string()->notNull(),
            'amount' => $this->double()->defaultValue(0)->notNull(),
            'profit' => $this->double()->defaultValue(0)->notNull(),
            'status' => $this->tinyInteger()->defaultValue(1)->notNull(),
            'sht_amount' => $this->integer()->notNull(),
            'kg_amount' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_by' => $this->timestamp()->notNull(),
            'updated_by' => $this->timestamp()->notNull()
        ]);

        $this->addForeignKey(
            'fk-plan-factory_id',
            'plan',
            'factory_id',
            'factory',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-plan-created_by',
            'plan',
            'created_by',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-plan-updated_by',
            'plan',
            'updated_by',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'unique-plan-month-factory_id',
            'plan',
            ['month', 'factory_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%plan}}');
    }
}
