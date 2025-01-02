<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m240902_124344_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'name' => $this->string()->notNull()->unique(),
            'unit' => "ENUM('кг', 'шт') NOT NULL",
            'price' => $this->double()->defaultValue(0),
            'cost_price' => $this->double()->defaultValue(0)->notNull(),
            'status' => $this->tinyInteger()->defaultValue(1)->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
            'created_by' => $this->timestamp()->notNull(),
            'updated_by' => $this->timestamp()->notNull()
        ]);

        $this->addForeignKey(
            'fk-product-category_id',
            'product',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product-created_by',
            'product',
            'created_by',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product-updated_by',
            'product',
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
        $this->dropTable('{{%product}}');
    }
}
