<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%job}}`.
 */
class m211029_025426_add_id_duration_column_to_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%job}}', 'id_duration', $this->integer()->notNull()->defaultValue(1));
        $this->addForeignKey('fk_job_eta', '{{%job}}', 'id_duration', '{{%duration}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_job_eta', '{{%job}}');
        $this->dropColumn('{{%job}}', 'id_duration');
    }
}
