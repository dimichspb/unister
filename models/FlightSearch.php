<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Flight;

/**
 * FlightSearch represents the model behind the search form about `app\models\Flight`.
 */
class FlightSearch extends Flight
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'origin_id', 'destination_id', 'airline_id', 'aircraft_id', 'seats'], 'integer'],
            [['departure', 'arrival', 'number'], 'safe'],
            [['price'], 'number'],
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
        $query = Flight::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
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
            'origin_id' => $this->origin_id,
            'destination_id' => $this->destination_id,
            'departure' => $this->departure,
            'arrival' => $this->arrival,
            'airline_id' => $this->airline_id,
            'aircraft_id' => $this->aircraft_id,
            'seats' => $this->seats,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number]);

        return $dataProvider;
    }
}
