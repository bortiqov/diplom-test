<?php


namespace common\modules\post\migration;


use yii\db\Migration;

class PostImageMigration extends Migration

{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_img}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'file_id' => $this->integer(),
            'sort' => $this->integer(),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-post_img-post_id}}',
            '{{%post_img}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-post_img-post_id}}',
            '{{%post_img}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );

        // creates index for column `file_id`
        $this->createIndex(
            '{{%idx-post_img-file_id}}',
            '{{%post_img}}',
            'file_id'
        );

        // add foreign key for table `{{%file}}`
        $this->addForeignKey(
            '{{%fk-post_img-file_id}}',
            '{{%post_img}}',
            'file_id',
            '{{%file}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-post_img-post_id}}',
            '{{%post_img}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-post_img-post_id}}',
            '{{%post_img}}'
        );

        // drops foreign key for table `{{%file}}`
        $this->dropForeignKey(
            '{{%fk-post_img-file_id}}',
            '{{%post_img}}'
        );

        // drops index for column `file_id`
        $this->dropIndex(
            '{{%idx-post_img-file_id}}',
            '{{%post_img}}'
        );

        $this->dropTable('{{%post_img}}');
    }
}