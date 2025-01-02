<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m241227_124524_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'factory_id' => $this->integer()->notNull(),
            'month' => $this->string()->notNull(),
            'start_date' => $this->string()->notNull(),
            'end_date' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'reason' => $this->text(),
            'status' => $this->tinyInteger()->defaultValue(0)->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_by' => $this->timestamp()->notNull(),
            'updated_by' => $this->timestamp()->notNull()
        ]);

        $this->addForeignKey(
            'fk-task-factory_id',
            'task',
            'factory_id',
            'factory',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-task-created_by',
            'task',
            'created_by',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-task-updated_by',
            'task',
            'updated_by',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
