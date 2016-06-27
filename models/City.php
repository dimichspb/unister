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
            'iata' => 'Iata',
        ];
    }

    /**
     * @param $iata
     * @return City
     */
    public static function findByIATA($iata)
    {
        return City::findOne(['iata' => $iata]);
    }
}
