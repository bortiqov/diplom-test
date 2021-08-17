<?php

namespace common\modules\menu\migrations;

use yii\db\Migration;

/**
 * Class m180813_082053_create_table_menu
 */
class Menu extends Migration
{
    private $tableName = '{{%menu}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'menu_id' => $this->primaryKey(),
            'title' => ' json',
            'type' => $this->integer(),
            'alias' => $this->string(255)
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }

}
