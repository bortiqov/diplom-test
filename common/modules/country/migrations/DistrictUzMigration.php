<?php


namespace common\modules\country\migrations;


use yii\db\Migration;

class DistrictUzMigration extends Migration
{

    public $table = '{{%district_uz}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer(),
            'name' => 'json',
            'status' => $this->integer()->defaultValue(1),
            'top' => $this->integer(2)->defaultValue(0),
        ]);

        $this->createIndex('idx-district-region_id', $this->table, 'region_id');

        $this->addForeignKey(
            'fk-district-region_id-region-id',
            $this->table,
            'region_id',
            'region_uz',
            'id',
            'CASCADE'
        );

        $districts = [];
        $file = file_get_contents(\Yii::getAlias('common') . '/modules/country/migrations/data/all.json');
        $json = json_decode($file, true);
        if (!empty($json)) {
            foreach ($json['districts'] as $data){
                $districts[] = [
                    'id' => $data['id'],
                    'region_id' => $data['region_id'],
                    'name' => json_encode(['ru' => $data['name'], 'uz' => $data['name'], 'en' => $data['name']], JSON_UNESCAPED_SLASHES)
                ];
            }
        }

        $this->batchInsert($this->table, ['id','region_id','name'], $districts);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-district-region_id-region-id',
            $this->table
        );

        $this->dropIndex('idx-district-region_id', $this->table);

        $this->dropTable($this->table);
    }

}
