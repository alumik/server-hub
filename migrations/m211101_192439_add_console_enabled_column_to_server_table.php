<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%server}}`.
 */
class m211101_192439_add_console_enabled_column_to_server_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%server}}', 'console_enabled', $this->boolean()->notNull()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%server}}', 'console_enabled');
    }
}
