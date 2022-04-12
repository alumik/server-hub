<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%dictionary}}`.
 */
class m220412_122101_add_enabled_column_to_dictionary_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%dictionary}}', 'enabled', $this->boolean()->notNull()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%dictionary}}', 'enabled');
    }
}
