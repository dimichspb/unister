<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 * @property string $iata
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * Validation rules
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'iata'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['iata'], 'string', 'max' => 3],
            [['name', 'iata'], 'unique'],
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
            'iata' => 'IATA',
        ];
    }

    /**
     * Finds City by IATA code
     *
     * @param $iata
     * @return City
     */
    public static function findByIATA($iata)
    {
        $result = City::getDb()->cache(function ($db) use ($iata){
            return City::findOne(['iata' => $iata]);
        });
        return $result;
    }

    /**
     * Finds Flights where this City is Origin
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrigins()
    {
        return $this->hasMany(Flight::className(), ['origin_id' => 'id']);
    }

    /**
     * Finds Flights where this City is Destination
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinations()
    {
        return $this->hasMany(Flight::className(), ['destination_id' => 'id']);
    }

    /**
     * Checks if the City can be deleted
     *
     * @return bool
     */
    public function beforeDelete()
    {
        if ($this->getOrigins()->exists() || $this->getDestinations()->exists()) {//cant delete if City is used in Flights
            Yii::$app->session->addFlash('danger', 'Sorry, you cannot delete this record because there is relational Flights');
            return false;
        }
        return parent::beforeDelete();
    }

    /**
     * Finds City using DB cache
     *
     * @return mixed
     * @throws \Exception
     */
    public static function find()
    {
        $result = City::getDb()->cache(function ($db) {
            return parent::find();
        });
        return $result;
    }
}
