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
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
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
     * @return \yii\db\ActiveQuery
     */
    public function getOrigins()
    {
        return $this->hasMany(Flight::className(), ['origin_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinations()
    {
        return $this->hasMany(Flight::className(), ['destination_id' => 'id']);
    }

    public function beforeDelete()
    {
        if ($this->getOrigins()->exists() || $this->getDestinations()->exists()) {
            Yii::$app->session->addFlash('danger', 'Sorry, you cannot delete this record because there is relational Flights');
            return false;
        }
        return parent::beforeDelete();
    }

    public static function find()
    {
        $result = City::getDb()->cache(function ($db) {
            return parent::find();
        });
        return $result;
    }
}
