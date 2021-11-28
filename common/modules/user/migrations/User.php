<?php

namespace common\modules\user\migrations;

use Yii;
use yii\db\Migration;

class User extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'phone' => $this->string()->unique(),
            'token' => $this->string(255),
            'fcm_token' => $this->string(255),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(),
            'first_name' => $this->string(255),
            'last_name' => $this->string(255),
            'image_id' => $this->integer(),
            'country_id' => $this->integer(),
            'region_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'email' => 'admin@mail.com',
            'phone' => '998901234567',
            'token' => Yii::$app->security->generateRandomString(64),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('admin123'),
            'first_name' => "System",
            'last_name' => "Admin",
            'created_at' => date('U'),
            'updated_at' => date('U'),
            'status' => \common\modules\user\models\User::STATUS_ACTIVE
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
