<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Flight;
use yii\helpers\ArrayHelper;

/**
 * ChooseForm represents the Customer choice of Flight and Adults.
 *
 * @property integer $adults
 * @property integer $flight_id
 * @property Flight $flight
 */
class ChooseForm extends Flight
{
    /**
     * Number of seats customer wants to book
     *
     * @var
     */
    public $adults;
    /**
     * Flight id which the customer wants to book
     *
     * @var
     */
    public $flight_id;

    /**
     * Validation rules
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adults', 'flight_id'], 'integer'],
            [['adults', 'flight_id'], 'required']
        ];
    }

    /**
     * Finds the Flight which customer wants to book
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlight()
    {
        return $this->hasOne(Flight::className(), ['id' => 'flight_id']);
    }

}