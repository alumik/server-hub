<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Server;

/**
 * ServerSearch represents the model behind the search form of `app\models\Server`.
 */
class ServerSearch extends Server
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'show', 'show_gpu'], 'integer'],
            [['name', 'instance', 'gpu_instance', 'ip', 'ssh_user'], 'safe'],
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
        $query = Server::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
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
            'show' => $this->show,
            'show_gpu' => $this->show_gpu,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'instance', $this->instance])
            ->andFilterWhere(['like', 'gpu_instance', $this->gpu_instance])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'ssh_user', $this->ssh_user]);

        return $dataProvider;
    }
}
