<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service}}`.
 */
class m211128_114645_create_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'name' => 'json',
            'title' => 'json',
            'icon' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service}}');
    }
}
