<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * JobSearch represents the model behind the search form of `app\models\Job`.
 */
class JobSearch extends Job
{
    public $username;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'id_server', 'id_user', 'duration'], 'integer'],
            [['description', 'username', 'server_user'], 'safe'],
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
        $query = Job::find()
            ->joinWith(User::tableName());

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
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
            'job.status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_server' => $this->id_server,
            'id_user' => $this->id_user,
            'duration' => $this->duration,
        ]);

        $query->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'server_user', $this->server_user]);

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
