<?php
/**
 * Author: J.Namazov
 * email:  <jamwid07@mail.ru>
 * date:   03.11.2020
 */

namespace common\modules\category\migrations;

use yii\db\Migration;

class Category extends Migration
{
    public function safeUp()
    {
        $this->createTable("category", [
            'id' => $this->primaryKey(),
            'name' => 'jsonb',
            'parent_id' =>$this->integer(),
            'slug' =>$this->string(),
            'icon' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex(
            '{{%idx-category-parent_id}}',
            '{{%category}}',
            'parent_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-category-parent_id}}',
            '{{%category}}',
            'parent_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-category-parent_id}}',
            '{{%category}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-category-parent_id}}',
            '{{%category}}'
        );
        $this->dropTable("category");
    }
}