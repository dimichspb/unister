<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_type".
 *
 * @property integer $id
 * @property string $name
 */
class PaymentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['name'], 'required'],
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
        ];
    }

    /**
     * @param $name
     * @return PaymentType
     */
    public static function findByName($name)
    {
        $result = PaymentType::getDb()->cache(function ($db) use ($name){
            return PaymentType::findOne(['name' => $name]);
        });
        return $result;
    }

    public static function find()
    {
        $result = PaymentType::getDb()->cache(function ($db) {
            return parent::find();
        });
        return $result;
    }
}
