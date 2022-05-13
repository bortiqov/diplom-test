<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%banner}}`.
 */
class m220513_175541_add_position_column_to_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%banner}}', 'position', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%banner}}', 'position');
    }
}
