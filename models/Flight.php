<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "flight".
 *
 * @property integer $id
 * @property integer $origin_id
 * @property integer $destination_id
 * @property string $departure
 * @property string $arrival
 * @property integer $airline_id
 * @property integer $aircraft_id
 * @property string $number
 * @property integer $seats
 * @property double $price
 * @property integer $available
 * @property string $title
 *
 * @property Aircraft $aircraft
 * @property Airline $airline
 * @property City $destination
 * @property City $origin
 */
class Flight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flight';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['origin_id', 'destination_id', 'departure', 'arrival', 'airline_id', 'aircraft_id', 'number', 'seats', 'price'], 'required'],
            [['origin_id', 'destination_id', 'airline_id', 'aircraft_id', 'seats'], 'integer'],
            ['destination_id', 'compare', 'compareAttribute' => 'origin_id', 'operator' => '!='],
            ['arrival', 'compare', 'compareAttribute' => 'departure', 'operator' => '>'],
            [['departure', 'arrival'], 'safe'],
            [['price'], 'number'],
            [['number'], 'string', 'max' => 4],
            [['origin_id', 'destination_id', 'departure', 'arrival', 'airline_id', 'number'], 'unique', 'targetAttribute' => ['origin_id', 'destination_id', 'departure', 'arrival', 'airline_id', 'number'], 'message' => 'The combination of Origin ID, Destination ID, Departure, Arrival, Airline ID and Number has already been taken.'],
            [['aircraft_id'], 'exist', 'skipOnError' => true, 'targetClass' => Aircraft::className(), 'targetAttribute' => ['aircraft_id' => 'id']],
            [['airline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Airline::className(), 'targetAttribute' => ['airline_id' => 'id']],
            [['destination_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['destination_id' => 'id']],
            [['origin_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['origin_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'origin_id' => 'Origin city',
            'origin.name' => 'Origin city',
            'destination_id' => 'Destination city',
            'destination.name' => 'Destination City',
            'departure' => 'Departure',
            'arrival' => 'Arrival',
            'airline_id' => 'Airline',
            'airline.name' => 'Airline',
            'aircraft_id' => 'Aircraft',
            'aircraft.name' => 'Aircraft',
            'number' => 'Number',
            'seats' => 'Total seats',
            'available' => 'Available seats',
            'price' => 'Price/seat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAircraft()
    {
        return $this->hasOne(Aircraft::className(), ['id' => 'aircraft_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAirline()
    {
        return $this->hasOne(Airline::className(), ['id' => 'airline_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestination()
    {
        return $this->hasOne(City::className(), ['id' => 'destination_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrigin()
    {
        return $this->hasOne(City::className(), ['id' => 'origin_id']);
    }

    /**
     * @return int
     */
    public function getAvailable()
    {
        return $this->seats - 10;
    }

    public function getTitle()
    {
        return $this->origin->iata . ' - ' . $this->destination->iata . ' ' . $this->departure . ' ' . $this->arrival . ', ' . $this->airline->name;
    }
}
