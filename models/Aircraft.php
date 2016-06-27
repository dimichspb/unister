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
            'icao' => 'Icao',
        ];
    }

    /**
     * @param $icao
     * @return Aircraft
     */
    public static function findByICAO($icao)
    {
        return Aircraft::findOne(['icao' => $icao]);
    }
}
