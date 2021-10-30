<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%duration}}`.
 */
class m211029_024834_create_duration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%duration}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);
        $this->insert('{{%duration}}', ['name' => '未知']);
        $this->insert('{{%duration}}', ['name' => '小于一小时']);
        $this->insert('{{%duration}}', ['name' => '几小时']);
        $this->insert('{{%duration}}', ['name' => '几天']);
        $this->insert('{{%duration}}', ['name' => '几周']);
        $this->insert('{{%duration}}', ['name' => '长期']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%duration}}');
    }
}
