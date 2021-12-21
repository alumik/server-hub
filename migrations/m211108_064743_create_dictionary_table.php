<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dictionary}}`.
 */
class m211108_064743_create_dictionary_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dictionary}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'key' => $this->string()->notNull(),
            'value' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(0),
        ]);
        $this->createIndex('uindex_name_key', '{{%dictionary}}', ['name', 'key'], true);
        $this->insert('{{%dictionary}}', ['name' => 'message_mode', 'key' => 'primary', 'value' => '主要', 'sort' => 1]);
        $this->insert('{{%dictionary}}', ['name' => 'message_mode', 'key' => 'secondary', 'value' => '次要', 'sort' => 2]);
        $this->insert('{{%dictionary}}', ['name' => 'message_mode', 'key' => 'success', 'value' => '成功', 'sort' => 3]);
        $this->insert('{{%dictionary}}', ['name' => 'message_mode', 'key' => 'warning', 'value' => '警告', 'sort' => 4]);
        $this->insert('{{%dictionary}}', ['name' => 'message_mode', 'key' => 'danger', 'value' => '危险', 'sort' => 5]);
        $this->insert('{{%dictionary}}', ['name' => 'message_mode', 'key' => 'info', 'value' => '信息', 'sort' => 6]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration', 'key' => '1', 'value' => '未知', 'sort' => 1]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration', 'key' => '2', 'value' => '小于一小时', 'sort' => 2]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration', 'key' => '3', 'value' => '几小时', 'sort' => 3]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration', 'key' => '4', 'value' => '几天', 'sort' => 4]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration', 'key' => '5', 'value' => '一周', 'sort' => 5]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration', 'key' => '6', 'value' => '两周', 'sort' => 6]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration', 'key' => '7', 'value' => '三周', 'sort' => 7]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration', 'key' => '8', 'value' => '长期', 'sort' => 8]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration_sec', 'key' => '1', 'value' => '1555200000', 'sort' => 1]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration_sec', 'key' => '2', 'value' => '3600', 'sort' => 2]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration_sec', 'key' => '3', 'value' => '86400', 'sort' => 3]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration_sec', 'key' => '4', 'value' => '604800', 'sort' => 4]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration_sec', 'key' => '5', 'value' => '1209600', 'sort' => 5]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration_sec', 'key' => '6', 'value' => '1814400', 'sort' => 6]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration_sec', 'key' => '7', 'value' => '2419200', 'sort' => 7]);
        $this->insert('{{%dictionary}}', ['name' => 'job_duration_sec', 'key' => '8', 'value' => '1555200000', 'sort' => 8]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dictionary}}');
    }
}
