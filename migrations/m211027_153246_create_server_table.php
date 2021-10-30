<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%server}}`.
 */
class m211027_153246_create_server_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%server}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'instance' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%server}}');
    }
}
