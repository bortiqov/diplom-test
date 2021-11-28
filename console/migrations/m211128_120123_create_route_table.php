<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%route}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%point}}`
 * - `{{%service}}`
 */
class m211128_120123_create_route_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%route}}', [
            'id' => $this->primaryKey(),
            'position' => $this->integer(),
            'group_number' => $this->integer(),
            'point_id' => $this->integer(),
            'service_id' => $this->integer(),
        ]);

        // creates index for column `point_id`
        $this->createIndex(
            '{{%idx-route-point_id}}',
            '{{%route}}',
            'point_id'
        );

        // add foreign key for table `{{%point}}`
        $this->addForeignKey(
            '{{%fk-route-point_id}}',
            '{{%route}}',
            'point_id',
            '{{%point}}',
            'id',
            'CASCADE'
        );

        // creates index for column `service_id`
        $this->createIndex(
            '{{%idx-route-service_id}}',
            '{{%route}}',
            'service_id'
        );

        // add foreign key for table `{{%service}}`
        $this->addForeignKey(
            '{{%fk-route-service_id}}',
            '{{%route}}',
            'service_id',
            '{{%service}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%point}}`
        $this->dropForeignKey(
            '{{%fk-route-point_id}}',
            '{{%route}}'
        );

        // drops index for column `point_id`
        $this->dropIndex(
            '{{%idx-route-point_id}}',
            '{{%route}}'
        );

        // drops foreign key for table `{{%service}}`
        $this->dropForeignKey(
            '{{%fk-route-service_id}}',
            '{{%route}}'
        );

        // drops index for column `service_id`
        $this->dropIndex(
            '{{%idx-route-service_id}}',
            '{{%route}}'
        );

        $this->dropTable('{{%route}}');
    }
}
