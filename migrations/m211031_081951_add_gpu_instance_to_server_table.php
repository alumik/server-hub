<?php

use yii\db\Migration;

/**
 * Class m211031_081951_add_gpu_instance_to_server_table
 */
class m211031_081951_add_gpu_instance_to_server_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%server}}', 'gpu_instance', $this->string()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%server}}', 'gpu_instance');
    }
}
