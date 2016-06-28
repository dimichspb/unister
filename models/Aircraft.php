<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aircraft".
 *
 * @property integer $id
 * @property string $name
 * @property string $icao
 */
class Aircraft extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aircraft';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'icao'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['icao'], 'string', 'max' => 4],
            [['name'], 'unique'],
            [['icao'], 'unique'],
        ];
    }

    /**
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
     * @param $icao
     * @return Aircraft
     */
    public static function findByICAO($icao)
    {
        $result = Aircraft::getDb()->cache(function ($db) use ($icao){
            return Aircraft::findOne(['icao' => $icao]);
        });
        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlights()
    {
        return $this->hasMany(Flight::className(), ['aircraft_id' => 'id']);
    }

    public function beforeDelete()
    {
        if ($this->getFlights()->exists()) {
            Yii::$app->session->addFlash('danger', 'Sorry, you cannot delete this record because there is relational Flights');
            return false;
        }
        return parent::beforeDelete();
    }

    public static function find()
    {
        $result = Aircraft::getDb()->cache(function ($db) {
            return parent::find();
        });
        return $result;
    }
}
