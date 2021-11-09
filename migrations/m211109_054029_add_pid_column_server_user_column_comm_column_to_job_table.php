<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%job}}`.
 */
class m211109_054029_add_pid_column_server_user_column_comm_column_to_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%job}}', 'pid', $this->integer());
        $this->addColumn('{{%job}}', 'server_user', $this->string()->notNull());
        $this->addColumn('{{%job}}', 'comm', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%job}}', 'pid');
        $this->dropColumn('{{%job}}', 'server_user');
        $this->dropColumn('{{%job}}', 'comm');
    }
}
