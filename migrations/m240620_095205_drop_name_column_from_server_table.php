<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%server}}`.
 */
class m240620_095205_drop_name_column_from_server_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%server}}', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%server}}', 'name', $this->string()->notNull()->unique());
    }
}
