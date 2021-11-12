<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kill_history}}`.
 */
class m211126_055223_create_kill_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kill_history}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'id_server' => $this->integer()->notNull(),
            'pid' => $this->integer()->notNull(),
            'user' => $this->string()->notNull(),
            'command' => $this->text()->notNull(),
        ]);
        $this->addForeignKey('fk_kill_history_server', '{{%kill_history}}', 'id_server', '{{%server}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kill_history}}');
    }
}
