<?php
namespace tests\codeception\unit\models;

use app\models\PaymentType;
use Yii;
use yii\codeception\TestCase;
use app\models\LoginForm;
use Codeception\Specify;

class PaymentTypeTest extends TestCase
{
    use Specify;

    protected function tearDown()
    {
        if ($model = PaymentType::findByName('TEST_METHOD')) {
            $model->delete();
        }
        parent::tearDown();
    }

    public function testCreateNewPaymentType()
    {
        $model = new PaymentType();
        $model->name = 'TEST_METHOD';

        $this->specify('PaymentType should be created with specified Name', function () use ($model) {
            expect('model should validate new PaymentType', $model->validate())->true();
            expect('model should not contain errors with Name', $model->errors)->hasntKey('name');
            expect('model should be saved', $model->save())->true();
        });
    }

    public function testCreateNewPaymentTypeWithoutName()
    {
        $model = new PaymentType();

        $this->specify('PaymentType should not be created with no Name specified', function () use ($model) {
            expect('model should not validate new PaymentType', $model->validate())->false();
            expect('model should contain Name error', $model->errors)->hasKey('name');
            expect('model should not be saved', $model->save())->false();
        });
    }
}