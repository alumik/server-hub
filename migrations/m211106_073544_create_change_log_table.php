<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%change_log}}`.
 */
class m211106_073544_create_change_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%change_log}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%change_log}}');
    }
}
