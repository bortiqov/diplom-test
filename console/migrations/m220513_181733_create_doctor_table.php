<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%doctor}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%file}}`
 */
class m220513_181733_create_doctor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%doctor}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'lavozim' => $this->string(),
            'bio' => $this->string(),
            'logo_id' => $this->integer(),
            'status' => $this->integer(),
        ]);

        // creates index for column `logo_id`
        $this->createIndex(
            '{{%idx-doctor-logo_id}}',
            '{{%doctor}}',
            'logo_id'
        );

        // add foreign key for table `{{%file}}`
        $this->addForeignKey(
            '{{%fk-doctor-logo_id}}',
            '{{%doctor}}',
            'logo_id',
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
        // drops foreign key for table `{{%file}}`
        $this->dropForeignKey(
            '{{%fk-doctor-logo_id}}',
            '{{%doctor}}'
        );

        // drops index for column `logo_id`
        $this->dropIndex(
            '{{%idx-doctor-logo_id}}',
            '{{%doctor}}'
        );

        $this->dropTable('{{%doctor}}');
    }
}
