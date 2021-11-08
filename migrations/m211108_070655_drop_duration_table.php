<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%duration}}`.
 */
class m211108_070655_drop_duration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_job_eta', '{{%job}}');
        $this->dropTable('{{%duration}}');
        $this->renameColumn('{{%job}}', 'id_duration', 'duration');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%duration}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);
        $this->insert('{{%duration}}', ['name' => '未知']);
        $this->insert('{{%duration}}', ['name' => '小于一小时']);
        $this->insert('{{%duration}}', ['name' => '几小时']);
        $this->insert('{{%duration}}', ['name' => '几天']);
        $this->insert('{{%duration}}', ['name' => '一周']);
        $this->insert('{{%duration}}', ['name' => '两周']);
        $this->insert('{{%duration}}', ['name' => '三周']);
        $this->insert('{{%duration}}', ['name' => '长期']);
        $this->renameColumn('{{%job}}', 'duration', 'id_duration');
        $this->addForeignKey('fk_job_eta', '{{%job}}', 'id_duration', '{{%duration}}', 'id');
    }
}
