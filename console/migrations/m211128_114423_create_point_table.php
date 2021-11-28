<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%point}}`.
 */
class m211128_114423_create_point_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%point}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'lat' => $this->float(),
            'lon' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%point}}');
    }
}
