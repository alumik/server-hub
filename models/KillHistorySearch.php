<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class KillHistorySearch extends KillHistory
{
    public function rules()
    {
        return [
            [['id_server', 'pid'], 'integer'],
            [['user', 'command'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = KillHistory::find();

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
            'id_server' => $this->id_server,
            'pid' => $this->pid,
        ]);

        $query->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'command', $this->command]);

        return $dataProvider;
    }
}
