<?php

namespace common\modules\tag\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 * Has foreign keys to the tables:
 *
 * - `language`
 */
class TagMigration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = null;
        if($this->getDb()->getDriverName() == 'mysql') {
            $options = "character set utf8 collate utf8_general_ci engine=InnoDB";
        }

        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'name' => 'jsonb',
        ], $options);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tag');
    }
}
