<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

class JobSearch extends Job
{
    public $username;
    public $show_outdated;

    public function rules()
    {
        return [
            [['status', 'id_server', 'id_user', 'duration', 'pid'], 'integer'],
            [['description', 'username', 'server_user'], 'safe'],
            [['show_outdated'], 'boolean'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $durationSec = Dictionary::find()
            ->select(['key', 'value'])
            ->where(['name' => 'job_duration_sec']);
        $query = Job::find()
            ->joinWith(User::tableName())
            ->leftJoin(['duration_sec' => $durationSec], 'job.duration = duration_sec.key');

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
            'job.status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id_server' => $this->id_server,
            'id_user' => $this->id_user,
            'duration' => $this->duration,
            'pid' => $this->pid,
        ]);

        $query->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'server_user', $this->server_user]);

        if (!$this->show_outdated) {
            $now = time();
            $query->andFilterWhere([
                '<',
                new Expression("$now - job.created_at"),
                new Expression('value')
            ]);
        }

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
