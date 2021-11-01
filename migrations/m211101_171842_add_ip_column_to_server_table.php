<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%server}}`.
 */
class m211101_171842_add_ip_column_to_server_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%server}}', 'ip', $this->string()->notNull()->unique());
        $this->addColumn('{{%server}}', 'ssh_user', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%server}}', 'ip');
        $this->dropColumn('{{%server}}', 'ssh_user');
    }
}
