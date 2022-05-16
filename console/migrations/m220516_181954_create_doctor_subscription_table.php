<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%doctor_subscription}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%doctor}}`
 * - `{{%user}}`
 */
class m220516_181954_create_doctor_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%doctor_subscription}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'date' => $this->integer(),
            'doctor_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'status' => $this->integer(),
        ]);

        // creates index for column `doctor_id`
        $this->createIndex(
            '{{%idx-doctor_subscription-doctor_id}}',
            '{{%doctor_subscription}}',
            'doctor_id'
        );

        // add foreign key for table `{{%doctor}}`
        $this->addForeignKey(
            '{{%fk-doctor_subscription-doctor_id}}',
            '{{%doctor_subscription}}',
            'doctor_id',
            '{{%doctor}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-doctor_subscription-user_id}}',
            '{{%doctor_subscription}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-doctor_subscription-user_id}}',
            '{{%doctor_subscription}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%doctor}}`
        $this->dropForeignKey(
            '{{%fk-doctor_subscription-doctor_id}}',
            '{{%doctor_subscription}}'
        );

        // drops index for column `doctor_id`
        $this->dropIndex(
            '{{%idx-doctor_subscription-doctor_id}}',
            '{{%doctor_subscription}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-doctor_subscription-user_id}}',
            '{{%doctor_subscription}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-doctor_subscription-user_id}}',
            '{{%doctor_subscription}}'
        );

        $this->dropTable('{{%doctor_subscription}}');
    }
}
