<?php


namespace common\modules\country\migrations;


use yii\db\Migration;

class CountryMigration extends Migration
{

    public $table = '{{%country}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => ' json',
            'iso2' => $this->string(),
            'iso3' => $this->string(),
            'phone_code' => $this->string(),
            'currency' => $this->string(),
            'status' => $this->integer()->defaultValue(1)
        ]);

        $countries = [];
        $file = fopen(\Yii::getAlias('common') . '/modules/country/migrations/data/countries.csv', 'rb');
        if (empty($file) === false) {
            while (($data = fgetcsv($file, 500)) !== FALSE) {
                $countries[] = [
                    'id' => $data[0],
                    'name' => json_encode(['ru' => $data[1], 'uz' => $data[1], 'en' => $data[1]], JSON_UNESCAPED_SLASHES),
                    'iso2' => $data[2],
                    'iso3' => $data[3],
                    'phone_code' => $data[4],
                    'currency' => $data[5],
                ];
            }
            fclose($file);
        }
        $this->batchInsert($this->table, ['id', 'name', 'iso2', 'iso3', 'phone_code', 'currency'], $countries);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
