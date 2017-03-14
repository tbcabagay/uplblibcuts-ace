<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sale;

/**
 * SaleSearch represents the model behind the search form about `app\models\Sale`.
 */
class SaleSearch extends Sale
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service', 'quantity'], 'integer'],
            [['name', 'number', 'created_by'], 'safe'],
            ['created_at', 'date', 'format' => 'php:Y-m-d'],
            ['total', 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Sale::find();
        $query->leftJoin('{{%student}}', '{{%student}}.id = {{%sale}}.student');
        $query->leftJoin('{{%user}}', '{{%user}}.id = {{%sale}}.created_by');
        $query->where([
            '{{%sale}}.library' => Yii::$app->user->identity->library,
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        $dataProvider->sort->attributes['number'] = [
            'asc' => ['{{%student}}.number' => SORT_ASC],
            'desc' => ['{{%student}}.number' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['name'] = [
            'asc' => ['{{%student}}.lastname' => SORT_ASC],
            'desc' => ['{{%student}}.lastname' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['created_by'] = [
            'asc' => ['{{%user}}.name' => SORT_ASC],
            'desc' => ['{{%user}}.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'service' => $this->service,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'FROM_UNIXTIME({{%sale}}.`created_at`, "%Y-%m-%d")' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', '{{%student}}.number', $this->number]);

        foreach (explode(' ', $this->name) as $name) {
            $query->andFilterWhere(['or', ['like', '{{%student}}.lastname', $name], ['like', '{{%student}}.firstname', $name]]);
        }

        foreach (explode(' ', $this->created_by) as $name) {
            $query->andFilterWhere(['like', '{{%user}}.name', $name]);
        }

        return $dataProvider;
    }
}
