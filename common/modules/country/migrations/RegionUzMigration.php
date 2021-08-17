<?php


namespace common\modules\country\migrations;


use yii\db\Migration;

class RegionUzMigration extends Migration
{

    public $table = '{{%region_uz}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => 'json',
            'status' => $this->integer()->defaultValue(1),
            'top' => $this->integer(2)->defaultValue(0),
        ]);

        $regions = [];
        $file = file_get_contents(\Yii::getAlias('common') . '/modules/country/migrations/data/all.json');
        $json = json_decode($file, true);
        if (!empty($json)) {
            foreach ($json['regions'] as $data){
                $regions[] = [
                    'id' => $data['id'],
                    'name' => json_encode(['ru' => $data['name'], 'uz' => $data['name'], 'en' => $data['name']], JSON_UNESCAPED_SLASHES)
                ];
            }
        }

        $this->batchInsert($this->table, ['id', 'name'], $regions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
