<?php


namespace common\modules\country\migrations;


use yii\db\Migration;

class RegionMigration extends Migration
{

    public $table = '{{%region}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => 'json',
            'country_id' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
            'top' => $this->integer(2)->defaultValue(0),
        ]);

        $this->createIndex('idx-region-country_id', $this->table, 'country_id');

        $this->addForeignKey(
        'fk-region-country_id-country-id',
            $this->table,
            'country_id',
            'country',
            'id',
            'CASCADE'
        );

        $regions = [];
        $file = fopen(\Yii::getAlias('common') . '/modules/country/migrations/data/regions.csv', 'rb');
        if (empty($file) === false) {
            while (($data = fgetcsv($file, 500)) !== FALSE) {
                $regions[] = [
                    'id' => $data[0],
                    'name' => json_encode(['ru' => $data[2], 'uz' => $data[2], 'en' => $data[2]], JSON_UNESCAPED_SLASHES),
                    'country_id' => $data[1],
                ];
            }
            fclose($file);
        }
        $this->batchInsert($this->table, ['id', 'name', 'country_id'], $regions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'fk-region-country_id-country-id',
            $this->table
        );

        $this->dropIndex('idx-region-country_id', $this->table);

        $this->dropTable($this->table);
    }

}
