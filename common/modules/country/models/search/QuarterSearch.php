<?php

namespace common\modules\country\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\country\models\Quarter;

/**
 * QuarterSearch represents the model behind the search form of `common\modules\country\models\Quarter`.
 */
class QuarterSearch extends Quarter
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'district_id', 'status', 'top'], 'integer'],
            [['name'], 'safe'],
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
        $query = Quarter::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $this->setAttributes($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'district_id' => $this->district_id,
            'status' => $this->status,
            'top' => $this->top,
        ]);

        $query->andWhere("(lower(name->>'ru') ILIKE '%$this->name%') or (lower(name->>'en') ILIKE '%$this->name%') or (lower(name->>'uz') ILIKE '%$this->name%')");

        return $dataProvider;
    }
}
