<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%storage_product}}`.
 */
class m250102_141236_create_storage_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%storage_product}}', [
            'storage_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'price' => $this->double()->notNull(),
            'cost_price' => $this->double()->notNull(),
            'amount' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-storage_product-product_id',
            'storage_product',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-storage_product-storage_id',
            'storage_product',
            'storage_id',
            'storage',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'unique-storage_product-ids',
            'storage_product',
            ['storage_id', 'product_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%storage_product}}');
    }
}
