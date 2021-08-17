<?php


namespace common\modules\country\migrations;


use yii\db\Migration;

class QuarterUzMigration extends  Migration
{

    public $table = '{{%quarter_uz}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'district_id' => $this->integer(),
            'name' => 'json',
            'status' => $this->integer()->defaultValue(1),
            'top' => $this->integer(2)->defaultValue(0),
        ]);

        $this->createIndex('idx-quarter-district_id', $this->table, 'district_id');

        $this->addForeignKey(
            'fk-quarter-district_id-district-id',
            $this->table,
            'district_id',
            'district_uz',
            'id',
            'CASCADE'
        );

        $quarters = [];
        $file = file_get_contents(\Yii::getAlias('common') . '/modules/country/migrations/data/all.json');
        $json = json_decode($file, true);
        if (!empty($json)) {
            foreach ($json['quarters'] as $data){
                $quarters[] = [
                    'id' => $data['id'],
                    'district_id' => $data['district_id'],
                    'name' => json_encode(['ru' => $data['name'], 'uz' => $data['name'], 'en' => $data['name']], JSON_UNESCAPED_SLASHES)
                ];
            }
        }

        $this->batchInsert($this->table, ['id','district_id','name'], $quarters);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-quarter-district_id-district-id',
            $this->table
        );

        $this->dropIndex('idx-quarter-district_id', $this->table);

        $this->dropTable($this->table);
    }

}