<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "booking".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $flight_id
 * @property integer $adults
 * @property integer $payment_type_id
 * @property string $username
 * @property string $password
 *
 * @property Flight $flight
 * @property PaymentType $paymentType
 * @property User|null $user This property is read-only.
 */
class Booking extends \yii\db\ActiveRecord
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'booking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flight_id', 'payment_type_id'], 'required'],
            [['username', 'password'], 'string'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            [['user_id', 'flight_id', 'adults', 'payment_type_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id', 'flight_id'], 'unique', 'targetAttribute' => ['user_id', 'flight_id'], 'message' => 'You cannot book the same Flight twice.'],
            [['flight_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flight::className(), 'targetAttribute' => ['flight_id' => 'id']],
            [['payment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentType::className(), 'targetAttribute' => ['payment_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flight_id' => 'Flight ID',
            'adults' => 'Adults',
            'username' => 'Username',
            'password' => 'Password',
            'payment_type_id' => 'Payment Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlight()
    {
        return $this->hasOne(Flight::className(), ['id' => 'flight_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentType()
    {
        return $this->hasOne(PaymentType::className(), ['id' => 'payment_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    //public function getUser()
    //{
    //    return $this->hasOne(User::className(), ['id' => 'user_id']);
    //}

    public function beforeSave($insert)
    {
        if ($this->adults > $this->flight->available) {
            Yii::$app->session->addFlash('danger', 'Sorry, there is no enough available seats in this flight');
            return false;
        }
        $now = new \DateTime();
        $this->updated_at = $now->format('Y-m-d H:i:s');
        if ($insert) {
            $this->created_at = $now->format('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0)) {
                $this->user_id = $this->getUser()->id;
                return true;
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            if (Yii::$app->user->isGuest) {
                $this->_user = User::findByUsername($this->username);
            } else {
                $this->_user = Yii::$app->user->getIdentity();
            }
        }

        return $this->_user;
    }
}
