<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%storage}}`.
 */
class m250102_140753_create_storage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%storage}}', [
            'id' => $this->primaryKey(),
            'factory_id' => $this->integer()->notNull(),
            'date' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-storage-factory_id',
            'storage',
            'factory_id',
            'factory',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-storage-created_by',
            'storage',
            'created_by',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-storage-updated_by',
            'storage',
            'updated_by',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'unique-storage-date-factory_id',
            'storage',
            ['date', 'factory_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%storage}}');
    }
}
