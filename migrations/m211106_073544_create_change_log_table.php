<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%changelog}}`.
 */
class m211106_073544_create_change_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%changelog}}', [
            'id' => $this->primaryKey(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%changelog}}');
    }
}
