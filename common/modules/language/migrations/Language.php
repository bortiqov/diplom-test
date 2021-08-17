<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package tourline
 */

namespace common\modules\language\migrations;


use yii\db\Migration;

class Language extends Migration
{

    private $table = '{{%language}}';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string(),
            'status' => $this->integer()->defaultValue(1)
        ]);

        $this->insert($this->table, [
            'name' => 'English',
            'code' => 'en'
        ]);

        $this->insert($this->table, [
            'name' => 'Russian',
            'code' => 'ru'
        ]);

        $this->insert($this->table, [
            'name' => 'Uzbek',
            'code' => 'uz'
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
