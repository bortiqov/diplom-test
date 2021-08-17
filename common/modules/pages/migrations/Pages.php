<?php

namespace common\modules\pages\migrations;

use yii\db\Migration;

class Pages extends Migration
{
    private $tableName = '{{%page}}';
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
            'id' => $this->primaryKey(),
            'title' => ' json',
            'subtitle' => ' json',
            'description' => ' json',
            'content' => ' json',
            'slug' => $this->string(255),
            'template' => $this->string(255),
            'date_create' => $this->integer(),
            'date_update' => $this->integer(),
            'date_publish' => $this->integer(),
            'sort' => $this->integer(11),
            'status' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-page-slug', $this->tableName, 'slug');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-page-slug', $this->tableName);
        $this->dropTable($this->tableName);
    }
}