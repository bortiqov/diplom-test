<?php

namespace common\modules\pages\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use common\modules\pages\models\Pages;

/**
 * PagesSearch represents the model behind the search form of `common\modules\pages\models\Pages`.
 */
class PagesSearch extends Pages
{
    public $tag = null;
    public $topic = null;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [["id","title","subtitle","description","content","slug","template","sort","date_update","date_create","date_publish","status"],'safe']
              ];
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

        $query = Pages::find();
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
            'page.id' => $this->id,
            'page.sort' => $this->sort,
            'page.status' => $this->status,
        ]);

        /**
         * date end
         */
        $query->andFilterWhere(['ilike', 'page.title', $this->title])
            ->andFilterWhere(['ilike', 'page.subtitle', $this->subtitle])
            ->andFilterWhere(['ilike', 'page.description', $this->description])
            ->andFilterWhere(['ilike', 'page.content', $this->content])
            ->andFilterWhere(['ilike', 'page.template', $this->template]);

        return $dataProvider;
    }
}
