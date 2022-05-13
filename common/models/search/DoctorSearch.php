<?php

namespace common\models\search;

use common\models\Doctor;
use common\models\Partner;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Banner;

/**
 * Banner represents the model behind the search form of `common\models\Banner`.
 */
class DoctorSearch extends Doctor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'lavozim', 'bio'], 'string',],
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
        $query = Doctor::find();

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

        $query->andFilterWhere(['first_name', 'ILIKE', $this->first_name]);
        $query->andFilterWhere(['last_name', 'ILIKE', $this->last_name]);
        $query->andFilterWhere(['bio', 'ILIKE', $this->bio]);


        return $dataProvider;
    }
}
