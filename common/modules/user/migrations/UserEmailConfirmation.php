<?php

namespace common\modules\user\migrations;

use Yii;
use yii\db\Migration;

class UserEmailConfirmation extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_email_confirmation}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'email' => $this->string(),
            'code' => $this->string(),
            'created_at' => $this->integer(),
            'expires_at' => $this->integer(),
            'status' => $this->integer(),
        ], $tableOptions);

        $this->createIndex(
            'idx-user_email_confirmation-user_id--user-id',
            'user_email_confirmation',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_email_confirmation-user_id--user-id',
            'user_email_confirmation',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%user_email_confirmation}}');
    }
}
