<?php

namespace common\modules\user\models;

use common\modules\product\models\ProductPrice;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\user\models\User;

/**
 * UserSearch represents the model behind the search form of `common\modules\user\models\User`.
 */
class UserSearch extends User
{
    public $name;
    public $store_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'image_id', 'branch_id', 'created_at', 'updated_at', 'deleted_at', 'status'], 'integer'],
            [['username', 'email', 'token', 'fcm_token', 'auth_key', 'password_hash', 'verification_token'], 'safe'],
            [['name'], 'string'],
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
        $query = User::find();

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


        if (!\Yii::$app->params['admin']){
            if ($this->name) {
                $query->leftJoin('user_info as ui','public.user.id=ui.user_id');
                $query->andWhere(['ilike', 'ui.first_name', $this->name]);

            }
            $query->andWhere(['status' => User::STATUS_ACTIVE])->andWhere(['<>','public.user.id',\Yii::$app->user->id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'type' => $this->type,
            'image_id' => $this->image_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'status' => $this->status,
            'ms.store_id' => $this->store_id,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'token', $this->token])
            ->andFilterWhere(['ilike', 'fcm_token', $this->fcm_token])
            ->andFilterWhere(['ilike', 'auth_key', $this->auth_key])
            ->andFilterWhere(['ilike', 'password_hash', $this->password_hash])
            ->andFilterWhere(['ilike', 'verification_token', $this->verification_token]);

        return $dataProvider;
    }
}
