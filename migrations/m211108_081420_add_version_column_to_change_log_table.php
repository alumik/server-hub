<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%change_log}}`.
 */
class m211108_081420_add_version_column_to_change_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%change_log}}', 'version', $this->string()->notNull());
        $this->dropColumn('{{%change_log}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%change_log}}', 'updated_at', $this->integer()->notNull());
        $this->dropColumn('{{%change_log}}', 'version');
    }
}
