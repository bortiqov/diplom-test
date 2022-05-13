<?php

namespace common\models\search;

use common\models\Partner;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Banner;

/**
 * Banner represents the model behind the search form of `common\models\Banner`.
 */
class PartnerSearch extends Partner
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','title', 'description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Partner::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

       if ($this->title){
           $query->andWhere("(LOWER(title::text) ILIKE '%$this->title%')");
       }

        if ($this->description){
            $query->andWhere("(LOWER(description::text) ILIKE '%$this->description%')");
        }

        return $dataProvider;
    }
}
