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
     * Table name
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_type';
    }

    /**
     * Validation rules
     *
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
     * Attribute labels
     *
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
     * Finds PaymentType by name
     *
     * @param $name
     * @return PaymentType
     */
    public static function findByName($name)
    {
        return PaymentType::findOne(['name' => $name]);
    }

    /**
     * Finds PaymentType using DB cache
     *
     * @return mixed
     * @throws \Exception
     */
    public static function find()
    {
        $result = PaymentType::getDb()->cache(function ($db) {
            return parent::find();
        });
        return $result;
    }
}
