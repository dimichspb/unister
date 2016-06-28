<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Flight;
use yii\helpers\ArrayHelper;

/**
 * FlightSearch represents the model behind the search form about `app\models\Flight`.
 *
 * @property integer $adults
 * @property integer $flight_id
 * @property Flight $flight
 */
class ChooseForm extends Flight
{
    public $adults;
    public $flight_id;

    /**
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
     * @return \yii\db\ActiveQuery
     */
    public function getFlight()
    {
        return $this->hasOne(Flight::className(), ['id' => 'flight_id']);
    }

}