<?php

namespace common\modules\file\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\file\models\File;

/**
 * FileSearch represents the model behind the search form of `common\modules\file\models\File`.
 */
class FileSearch extends File
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date_create', 'user_id', 'status', 'secure'], 'integer'],
            [['name', 'title', 'description', 'caption', 'mime_type', 'extension'], 'safe'],
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
        $query = File::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => ['id' => SORT_DESC]
			],
			'pagination' => [
				'pageSize' => 21
			]

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
            'date_create' => $this->date_create,
            'status' => $this->status,
            'secure' => $this->secure,
            'user_id' => $this->user_id,
            'extension' => $this->extension,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'caption', $this->caption])
            ->andFilterWhere(['like', 'description', $this->description])
//            ->andFilterWhere(['ilike', 'mime_type', $this->mime_type])
			->andFilterWhere(['<>', 'status', File::STATUS_DELETED]);
//            ->andFilterWhere(['like', 'extension', $this->extension]);

        return $dataProvider;
    }
}
