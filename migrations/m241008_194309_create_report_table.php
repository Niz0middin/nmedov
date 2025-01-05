<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report}}`.
 */
class m241008_194309_create_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report}}', [
            'id' => $this->primaryKey(),
            'factory_id' => $this->integer()->notNull(),
            'date' => $this->string()->notNull(),
            'cash_amount' => $this->double()->defaultValue(0)->notNull(),
            'transfer_amount' => $this->double()->defaultValue(0)->notNull(),
            'expense' => $this->double()->defaultValue(0)->notNull(),
            'expense_description' => $this->string(),
            'status' => $this->tinyInteger()->defaultValue(0)->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-report-factory_id',
            'report',
            'factory_id',
            'factory',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-report-created_by',
            'report',
            'created_by',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-report-updated_by',
            'report',
            'updated_by',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'unique-report-date-factory_id',
            'report',
            ['date', 'factory_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report}}');
    }
}
