<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%message}}`.
 */
class m211108_093433_add_show_column_to_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%message}}', 'show', $this->boolean()->notNull()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%message}}', 'show');
    }
}
