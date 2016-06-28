<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

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
 * @property string $duration
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
            [['origin_id', 'destination_id', 'departure', 'arrival', 'airline_id', 'number'], 'unique', 'targetAttribute' => ['origin_id', 'destination_id', 'departure', 'arrival', 'airline_id', 'number'], 'message' => 'You cannot create Flight with the same Origin, Destination, Departure, Arrival, Airline and Number twice.'],
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
            'duration' => 'Duration',
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
        return $this->seats - $this->getBookedSeatsCount();
    }

    public function getBookedSeatsCount()
    {
        if (!$this->getBookings()->exists()) {
            return 0;
        }
        return (int)$this->getBookings()->sum('adults');
    }

    public function getTitle()
    {
        return $this->origin->iata . ' - ' . $this->destination->iata . ' ' . $this->departure . ' ' . $this->arrival . ', ' . $this->airline->name;
    }

    public function getDuration()
    {
        $departure = new \DateTime($this->departure);
        $arrival = new \DateTime($this->arrival);
        $interval = $arrival->diff($departure);
        return $interval->format('%H:%i');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function checkUserBooking(User $user)
    {
        return $this->getUserBookings($user)->exists();
    }

    /**
     * @param User $user
     * @return ActiveQuery
     */
    public function getUserBookings(User $user)
    {
        return $this->getBookings()->where(['user_id' => $user->id]);
    }

    /**
     * @return ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::className(), ['flight_id' => 'id']);
    }
}
