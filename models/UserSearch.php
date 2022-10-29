<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id', 'admin'], 'integer'],
            [['student_id', 'username'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find()
            ->leftJoin(['_' =>
                (new Query())
                    ->select(['SUM(view_count) as view_count', 'id_user'])
                    ->from(SiteTraffic::tableName())
                    ->groupBy('id_user')], 'user.id = _.id_user'
            );

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]],
        ]);
        $dataProvider->sort->attributes['view_count'] = [
            'asc' => ['view_count' => SORT_ASC],
            'desc' => ['view_count' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'admin' => $this->admin,
            'student_id' => $this->student_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
