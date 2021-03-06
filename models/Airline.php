<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "airline".
 *
 * @property integer $id
 * @property string $name
 * @property string $icao
 */
class Airline extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'airline';
    }

    /**
     * Validation rules
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'icao'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['icao'], 'string', 'max' => 3],
            [['name', 'icao'], 'unique'],
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
            'name' => 'Name',
            'icao' => 'ICAO',
        ];
    }

    /**
     * Find Airline by ICAO code
     *
     * @param $icao
     * @return Airline
     */
    public static function findByICAO($icao)
    {
        return Airline::findOne(['icao' => $icao]);
    }

    /**
     * Finds Flights with this Airline
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlights()
    {
        return $this->hasMany(Flight::className(), ['airline_id' => 'id']);
    }

    /**
     * Check if Airline can be deleted
     *
     * @return bool
     */
    public function beforeDelete()
    {
        if ($this->getFlights()->exists()) {
            Yii::$app->session->addFlash('danger', 'Sorry, you cannot delete this record because there is relational Flights');
            return false;
        }
        return parent::beforeDelete();
    }

    /**
     * Find Airline using DB cache
     *
     * @return mixed
     * @throws \Exception
     */
    public static function find()
    {
        $result = Airline::getDb()->cache(function ($db) {
            return parent::find();
        });
        return $result;
    }
}
