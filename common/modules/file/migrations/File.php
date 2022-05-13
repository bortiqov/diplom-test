<?php

namespace common\modules\file\migrations;

use yii\db\Migration;

class File extends Migration
{
	public function safeUp()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%file}}', [
			'id'          => $this->primaryKey(),
			'name'        => $this->string()->notNull(),
			'title'       => $this->string(),
			'description' => $this->string(),
			'caption'     => $this->string(),
			'extension'   => $this->string()->notNull(),
			'mime_type'   => $this->string()->notNull(),
			'size'        => $this->integer()->notNull(),
			'date_create' => $this->integer()->notNull(),
			'user_id'     => $this->integer()->notNull(),
			'secure'      => $this->integer()->defaultValue(0),
			'status'      => $this->integer()->defaultValue(\common\modules\file\models\File::STATUS_ACTIVE)
		], $tableOptions);

		$this->createIndex(
			'idx-file-users-user-id',
			'{{%file}}',
			'[[user_id]]'
		);

		$this->addForeignKey(
			'fk-file-users-user-id',
			'{{%file}}',
			'[[user_id]]',
			'{{%user}}',
			'[[id]]',
			'CASCADE'
		);
	}

	public function safeDown()
	{
		$this->dropForeignKey(
			'fk-file-users-user-id',
			'{{%file}}'
		);

		$this->dropIndex(
			'idx-file-users-user-id',
			'{{%file}}'
		);

		$this->dropTable('{{%file}}');
	}
}