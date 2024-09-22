<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%factory_product}}`.
 */
class m240922_081828_create_factory_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%factory_product}}', [
            'factory_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-factory_product-product_id',
            'factory_product',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-factory_product-factory_id',
            'factory_product',
            'factory_id',
            'factory',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'unique-factory_product-ids',
            'factory_product',
            ['factory_id', 'product_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%factory_product}}');
    }
}
