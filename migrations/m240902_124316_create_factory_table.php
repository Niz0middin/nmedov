<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%factory}}`.
 */
class m240902_124316_create_factory_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%factory}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'status' => $this->tinyInteger()->defaultValue(1)->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-factory-created_by',
            'factory',
            'created_by',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-factory-updated_by',
            'factory',
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
        $this->dropTable('{{%factory}}');
    }
}
