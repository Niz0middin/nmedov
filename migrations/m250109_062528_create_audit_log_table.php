<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%audit_log}}`.
 */
class m250109_062528_create_audit_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%audit_log}}', [
            'id' => $this->primaryKey(),
            'table_name' => $this->string(255)->notNull(),
            'row_id' => $this->integer()->notNull(),
            'action' => "ENUM('create', 'update', 'delete') NOT NULL",
            'changed_data' => $this->json()->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_by' => $this->integer()->null(),
        ]);

        $this->createIndex(
            '{{%idx-audit_log-table_name}}',
            '{{%audit_log}}',
            'table_name'
        );
        $this->createIndex(
            '{{%idx-audit_log-row_id}}',
            '{{%audit_log}}',
            'row_id'
        );
        $this->createIndex(
            '{{%idx-audit_log-action}}',
            '{{%audit_log}}',
            'action'
        );

         $this->addForeignKey(
             '{{%fk-audit_log-created_by}}',
             '{{%audit_log}}',
             'created_by',
             '{{%user}}',
             'id',
             'SET NULL',
             'CASCADE'
         );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropForeignKey('{{%fk-audit_log-created_by}}', '{{%audit_log}}');
        $this->dropIndex('{{%idx-audit_log-table_name}}', '{{%audit_log}}');
        $this->dropIndex('{{%idx-audit_log-row_id}}', '{{%audit_log}}');
        $this->dropIndex('{{%idx-audit_log-action}}', '{{%audit_log}}');
        $this->dropTable('{{%audit_log}}');
    }
}
