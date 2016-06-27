<?php

use yii\db\Migration;
use app\models\PaymentType;

class m160627_134625_adding_demo_payment_types extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $demoPaymentType1 = new PaymentType();
        $demoPaymentType1->name = 'VISA/MasterCard';
        $demoPaymentType1->save();

        $demoPaymentType2 = new PaymentType();
        $demoPaymentType2->name = 'PayPal';
        $demoPaymentType2->save();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $demoPaymentType1 = PaymentType::findByName('VISA/MasterCard');
        $demoPaymentType1->delete();

        $demoPaymentType2 = PaymentType::findByName('PayPal');
        $demoPaymentType2->delete();
    }
}
