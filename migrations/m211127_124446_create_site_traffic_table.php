<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%site_traffic}}`.
 */
class m211127_124446_create_site_traffic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%site_traffic}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'id_user' => $this->integer()->notNull(),
            'view_count' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createIndex('uindex_user_key', '{{%site_traffic}}', ['date', 'id_user'], true);
        $this->addForeignKey('fk_site_traffic_user', '{{%site_traffic}}', 'id_user', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%site_traffic}}');
    }
}
