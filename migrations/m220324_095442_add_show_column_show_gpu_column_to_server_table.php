<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%server}}`.
 */
class m220324_095442_add_show_column_show_gpu_column_to_server_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%server}}', 'show', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn('{{%server}}', 'show_gpu', $this->boolean()->notNull()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%server}}', 'show');
        $this->dropColumn('{{%server}}', 'show_gpu');
    }
}
