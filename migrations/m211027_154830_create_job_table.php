<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%job}}`.
 */
class m211027_154830_create_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%job}}', [
            'id' => $this->primaryKey(),
            'description' => $this->text()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'id_server' => $this->integer()->notNull(),
            'id_user' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_job_server', '{{%job}}', 'id_server', '{{%server}}', 'id');
        $this->addForeignKey('fk_job_user', '{{%job}}', 'id_user', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%job}}');
    }
}
