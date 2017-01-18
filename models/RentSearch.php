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
            [['id', 'student', 'college', 'degree', 'pc', 'service', 'status', 'time_in', 'time_out', 'rent_time', 'time_diff', 'created_by', 'updated_by'], 'integer'],
            [['topic'], 'safe'],
            [['amount'], 'number'],
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
            'student' => $this->student,
            'college' => $this->college,
            'degree' => $this->degree,
            'pc' => $this->pc,
            'service' => $this->service,
            'amount' => $this->amount,
            'status' => $this->status,
            'time_in' => $this->time_in,
            'time_out' => $this->time_out,
            'rent_time' => $this->rent_time,
            'time_diff' => $this->time_diff,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'topic', $this->topic]);

        return $dataProvider;
    }
}
