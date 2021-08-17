<?php

namespace common\modules\post\migration;

class PostMigration extends \yii\db\Migration
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

        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'author' => $this->integer()->notNull(),
            'title' => 'jsonb',
            'description' => 'jsonb',
            'slug' => $this->string(),
            'photo' => $this->string(),
            'type' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'published_at' => $this->integer()->notNull(),
            'top' => $this->integer(),
            'viewed' => $this->integer(),
            'status' => $this->integer(),
            'anons' => $this->text(),
            'short_link' => $this->integer(8)
        ], $options);

        // creates index for column `author`
        $this->createIndex(
            'idx-post-author',
            'post',
            'author'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-author',
            'post',
            'author',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-post-author',
            'post'
        );

        // drops index for column `author`
        $this->dropIndex(
            'idx-post-author',
            'post'
        );
        $this->dropTable('post');
    }

}