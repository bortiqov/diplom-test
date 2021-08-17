<?php
/**
 * Author: J.Namazov
 * email:  <jamwid07@mail.ru>
 * date:   10.09.2020
 */

namespace common\modules\settings\migrations;

use yii\db\Migration;

/**
 * Class SettingsMigration provides settings model structure
 * @package common\modules\settings
 */
class SettingsMigration extends Migration
{
    public function safeUp()
    {
        $this->createTable("settings", [
            'setting_id' => $this->primaryKey(),
            'title' => $this->string(255),
            'description' => $this->string(255),
            'slug' => $this->string(255),
            'type' => $this->integer(),
            'input' => $this->integer(),
            'data' => $this->text(),
            'default' => $this->string(255),
            'sort' => $this->integer(),
            'lang' => $this->integer(),
            'lang_hash' => $this->string(255),
        ]);

        $this->createTable('values', [
            'value_id' => $this->primaryKey(),
            'type' => $this->integer(),
            'value' => $this->string(255),
        ]);

        $this->createTable("settingsvalues", [
            'setting_id' => $this->integer(),
            'value_id' => $this->integer(),
            'sort' => $this->integer(),
        ]);

        $this->createIndex('idx-settingsvalues-settings', 'settingsvalues', 'setting_id');
        $this->createIndex('idx-settingsvalues-values', 'settingsvalues', 'value_id');

        $this->addForeignKey(
            'fk-settings_id-settings-id',
            'settingsvalues',
            'setting_id',
            'settings',
            'setting_id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-values_id-values-id',
            'settingsvalues',
            'value_id',
            'values',
            'value_id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-values_id-values-id', 'settingsvalues');
        $this->dropForeignKey('fk-settings_id-settings-id', 'settingsvalues');
        $this->dropTable("settingsvalues");
        $this->dropTable("values");
        $this->dropTable("settings");
    }
}