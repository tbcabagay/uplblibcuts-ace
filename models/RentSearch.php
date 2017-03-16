<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rent;

/**
 * RentSearch represents the model behind the search form about `app\models\Rent`.
 */
class RentSearch extends Rent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['college', 'pc', 'service', 'status'], 'integer'],
            [['number', 'name', 'time_in', 'time_out'], 'safe'],
            ['time_diff', 'match', 'pattern' => '/^(\d+):(\d+):(\d+)$/'],
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
        $query = Rent::find();
        $query->leftJoin('{{%student}}', '{{%student}}.id = {{%rent}}.student');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'time_in' => SORT_DESC,
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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'college' => $this->college,
            'pc' => $this->pc,
            'service' => $this->service,
            '{{%rent}}.status' => $this->status,
            'FROM_UNIXTIME(`time_in`, "%Y-%m-%d")' => $this->time_in,
            'FROM_UNIXTIME(`time_out`, "%Y-%m-%d")' => $this->time_out,
        ]);

        $query->andFilterWhere(['like', '{{%student}}.number', $this->number]);

        $query->andFilterWhere(['<=', 'time_diff', $this->formatTimeDiffAsInteger()]);

        foreach (explode(' ', $this->name) as $name) {
            $query->andFilterWhere(['or', ['like', '{{%student}}.lastname', $name], ['like', '{{%student}}.firstname', $name]]);
        }

        return $dataProvider;
    }

    public function searchBacklog()
    {
        $query = Rent::find();
        $query->leftJoin('{{%student}}', '{{%student}}.id = {{%rent}}.student');
        $query->where(['{{%rent}}.status' => Rent::STATUS_TIME_IN]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'time_in' => SORT_ASC,
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

        return $dataProvider;
    }

    protected function formatTimeDiffAsInteger()
    {
        $timeDiff = null;
        $pieces = explode(':', $this->time_diff);
        if (is_array($pieces) && (count($pieces) === 3)) {
            $timeDiff = (($pieces[0] * 3600) + ($pieces[1] * 60) + $pieces[2]);
        }
        return $timeDiff;
    }
}
