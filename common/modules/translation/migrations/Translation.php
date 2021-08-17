<?php


namespace common\modules\translation\migrations;


use yii\db\Migration;

class Translation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('message', [
            'id' => $this->integer(),
            'language' => $this->string(16),
            'translation' => $this->text(),
        ]);

        $this->createTable('source_message', [
            'id' => $this->primaryKey(),
            'category' => $this->string(255),
            'message' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('source_message');
        $this->dropTable('message');
    }

}
