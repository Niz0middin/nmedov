<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report_product}}`.
 */
class m241008_195049_create_report_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report_product}}', [
            'report_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'price' => $this->double()->notNull(),
            'cost_price' => $this->double()->notNull(),
            'amount' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-report_product-product_id',
            'report_product',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-report_product-report_id',
            'report_product',
            'report_id',
            'report',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'unique-report_product-ids',
            'report_product',
            ['report_id', 'product_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%report_product}}');
    }
}
