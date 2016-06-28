<?php
namespace tests\codeception\unit\models;

use app\models\Airline;
use Yii;
use yii\codeception\TestCase;
use app\models\LoginForm;
use Codeception\Specify;

class AirlineTest extends TestCase
{
    use Specify;

    protected function tearDown()
    {
        if ($model = Airline::findByICAO('TAL')) {
            $model->delete();
        }
        parent::tearDown();
    }

    public function testCreateNewAirline()
    {
        $model = new Airline();
        $model->icao = 'TAL';
        $model->name = 'Test aircraft';

        $this->specify('Airline should be created with specified Name and ICAO', function () use ($model) {
            expect('model should validate new Airline', $model->validate())->true();
            expect('model should not contain errors with Name', $model->errors)->hasntKey('name');
            expect('model should not contain errors with ICAO', $model->errors)->hasntKey('icao');
            expect('model should be saved', $model->save())->true();
        });
    }

    public function testCreateNewAirlineWithoutICAO()
    {
        $model = new Airline();
        $model->name = 'Test airline';

        $this->specify('Airline should not be created with specified Name only', function () use ($model) {
            expect('model should not validate new Airline', $model->validate())->false();
            expect('model should contain ICAO error', $model->errors)->hasKey('icao');
            expect('model should not be saved', $model->save())->false();
        });
    }

    public function testCreateNewAirlineWithoutName()
    {
        $model = new Airline();
        $model->icao = 'TAL';

        $this->specify('Airline should not be created with specified ICAO only', function () use ($model) {
            expect('model should not validate new Airline', $model->validate())->false();
            expect('model should contain Name error', $model->errors)->hasKey('name');
            expect('model should not be saved', $model->save())->false();
        });
    }
}