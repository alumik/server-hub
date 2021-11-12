<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%changelog}}`.
 */
class m211108_081420_add_version_column_to_change_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%changelog}}', 'version', $this->string()->notNull());
        $this->dropColumn('{{%changelog}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%changelog}}', 'updated_at', $this->integer()->notNull());
        $this->dropColumn('{{%changelog}}', 'version');
    }
}
