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
     * Table name
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aircraft';
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
            [['icao'], 'string', 'max' => 4],
            [['name'], 'unique'],
            [['icao'], 'unique'],
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
     * Finds Aircraft by ICAO code
     *
     * @param $icao
     * @return Aircraft
     */
    public static function findByICAO($icao)
    {
        return Aircraft::findOne(['icao' => $icao]);
    }

    /**
     * Finds Flights with this Aircraft
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFlights()
    {
        return $this->hasMany(Flight::className(), ['aircraft_id' => 'id']);
    }

    /**
     * Check if Aircraft can be deleted
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
     * Find Aircraft using DB cache
     *
     * @return mixed
     * @throws \Exception
     */
    public static function find()
    {
        $result = Aircraft::getDb()->cache(function ($db) {
            return parent::find();
        });
        return $result;
    }
}
