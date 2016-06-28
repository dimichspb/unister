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
     * Table name
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flight';
    }

    /**
     * Validation rules
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['origin_id', 'destination_id', 'departure', 'arrival', 'airline_id', 'aircraft_id', 'number', 'seats', 'price'], 'required'],
            [['origin_id', 'destination_id', 'airline_id', 'aircraft_id', 'seats'], 'integer'],
            ['destination_id', 'compare', 'compareAttribute' => 'origin_id', 'operator' => '!='], //impossible to choose same city
            ['arrival', 'compare', 'compareAttribute' => 'departure', 'operator' => '>'], //arrival must be after departure
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
     * Attribute labels
     *
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
     * Finds Aircraft of this Flight
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAircraft()
    {
        return $this->hasOne(Aircraft::className(), ['id' => 'aircraft_id']);
    }

    /**
     * Finds Airline of this Flight
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAirline()
    {
        return $this->hasOne(Airline::className(), ['id' => 'airline_id']);
    }

    /**
     * Finds Destination City of this Flight
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestination()
    {
        return $this->hasOne(City::className(), ['id' => 'destination_id']);
    }

    /**
     * Finds Origin City of this Flight
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrigin()
    {
        return $this->hasOne(City::className(), ['id' => 'origin_id']);
    }

    /**
     * Returns the number of Available Seats
     *
     * @return int
     */
    public function getAvailable()
    {
        return $this->seats - $this->getBookedSeatsCount();
    }

    /**
     * Returns the number of Booked Seats
     *
     * @return int
     */
    public function getBookedSeatsCount()
    {
        if (!$this->getBookings()->exists()) {
            return 0;
        }
        return (int)$this->getBookings()->sum('adults');
    }

    /**
     * Returns the composite Title of the Flight
     *
     * @return string
     */
    public function getTitle()
    {
        return
            $this->origin->iata         . ' - ' .
            $this->destination->iata    . ' ' .
            $this->departure            . ' ' .
            $this->arrival              . ', ' .
            $this->airline->name;
    }

    /**
     * Returns Duration string of the Flight
     *
     * @return string
     */
    public function getDuration()
    {
        $departure = new \DateTime($this->departure);
        $arrival = new \DateTime($this->arrival);
        $interval = $arrival->diff($departure);
        // if the duration is more than 24H return number days
        return $interval->format($interval->d > 0? '%d days %H:%i':'%H:%i');
    }

    /**
     * Check if the specified User has booked this Flight
     *
     * @param User $user
     * @return bool
     */
    public function checkUserBooking(User $user)
    {
        return $this->getUserBookings($user)->exists();
    }

    /**
     * Finds Bookings of this Flight by the specified User
     *
     * @param User $user
     * @return ActiveQuery
     */
    public function getUserBookings(User $user)
    {
        return $this->getBookings()->where(['user_id' => $user->id]);
    }

    /**
     * Finds Bookings of this Flight
     *
     * @return ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::className(), ['flight_id' => 'id']);
    }

    /**
     * Checks if Flight can be deleter
     *
     * @return bool
     */
    public function beforeDelete()
    {
        if ($this->getBookings()->exists()) {//cannot delete the Flight if it has Bookings
            Yii::$app->session->addFlash('danger', 'Sorry, you cannot delete this record because there is relational Bookings');
            return false;
        }
        return parent::beforeDelete();
    }

    /**
     * Finds Flight using DB cache
     *
     * @return mixed
     * @throws \Exception
     */
    public static function find()
    {
        $result = Flight::getDb()->cache(function ($db) {
            return parent::find();
        });
        return $result;
    }
}
