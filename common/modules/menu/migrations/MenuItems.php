<?php

namespace common\modules\menu\migrations;

use yii\db\Migration;

/**
 * Class m180813_082103_create_table_menu_items
 */
class MenuItems extends Migration
{
    private $tableName = '{{%menu_items}}';
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
            'menu_item_id' => $this->primaryKey(),
            'menu_id' => $this->integer(),
            'title' => ' json',
            'url' => $this->string(),
            'sort' => $this->integer(),
            'menu_item_parent_id' => $this->integer(),
            'icon' => $this->string(255)
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
