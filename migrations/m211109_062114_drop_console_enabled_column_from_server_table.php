<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%server}}`.
 */
class m211109_062114_drop_console_enabled_column_from_server_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%server}}', 'console_enabled');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%server}}', 'console_enabled', $this->boolean()->notNull()->defaultValue(true));
    }
}
