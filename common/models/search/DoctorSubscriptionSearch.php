<?php

namespace common\models\search;

use common\models\Doctor;
use common\models\DoctorSubscription;
use common\models\User;
use common\modules\file\models\File;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Banner;

/**
 * Banner represents the model behind the search form of `common\models\Banner`.
 */
class DoctorSubscriptionSearch extends DoctorSubscription
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'doctor_id', 'user_id', 'created_at', 'status'], 'default', 'value' => null],
            [['date', 'doctor_id', 'user_id', 'created_at', 'status'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
        $query = DoctorSubscription::find();

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
            'status' => $this->status,
            'date' => $this->date,
            'doctor_id' => $this->doctor_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name]);

        return $dataProvider;
    }
}
