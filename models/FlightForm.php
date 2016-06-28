<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Flight;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * FlightSearch represents the model behind the search form about `app\models\Flight`.
 *
 * @property integer $adults
 */
class FlightForm extends Flight
{
    public $adults;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'origin_id', 'destination_id', 'airline_id', 'adults'], 'integer'],
            [['origin_id', 'destination_id', 'departure'], 'required'],
            [['departure'], 'date'],
            ['destination_id', 'compare', 'compareAttribute' => 'origin_id', 'operator' => '!='],
            [['airline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Airline::className(), 'targetAttribute' => ['airline_id' => 'id']],
            [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['destination_id' => 'id']],
            [['origin_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['origin_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),[
            'adults' => 'Adults',
        ]);
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
        $subQuery = Booking::find();
        $subQuery->select('flight_id, SUM(`adults`) as adults_sum')->groupBy('flight_id');
        $query->leftJoin(['booking' => $subQuery], 'booking.flight_id = id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => [
                'pageSize' => 5,
            ],
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
            'airline_id' => $this->airline_id,
        ]);

        $query->andFilterWhere([
            'between',
            'departure',
            Yii::$app->formatter->asDate($this->departure, 'php:Y-m-d 00:00:00'),
            Yii::$app->formatter->asDate($this->departure, 'php:Y-m-d 23:59:59'),
        ]);

        $query->andFilterWhere([
            '>=',
            new Expression('`flight`.`seats` - IFNULL(`booking`.`adults_sum`, 0)'),
            $this->adults
        ]);

        return $dataProvider;
    }
}
