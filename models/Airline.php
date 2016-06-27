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
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'airline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'icao'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['icao'], 'string', 'max' => 2],
            [['name', 'icao'], 'unique'],
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
     * @return Airline
     */
    public static function findByICAO($icao)
    {
        return Airline::findOne(['icao' => $icao]);
    }
}
