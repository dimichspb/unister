<?php
namespace tests\codeception\unit\models;

use app\models\Aircraft;
use Yii;
use yii\codeception\TestCase;
use app\models\LoginForm;
use Codeception\Specify;

class AircraftTest extends TestCase
{
    use Specify;

    protected function tearDown()
    {
        if ($model = Aircraft::findByICAO('TAIR')) {
            $model->delete();
        }
        parent::tearDown();
    }

    public function testCreateNewAircraft()
    {
        $model = new Aircraft();
        $model->icao = 'TAIR';
        $model->name = 'Test aircraft';

        $this->specify('Aircraft should be created with specified Name and ICAO', function () use ($model) {
            expect('model should validate new Aircraft', $model->validate())->true();
            expect('model should not contain errors with Name', $model->errors)->hasntKey('name');
            expect('model should not contain errors with ICAO', $model->errors)->hasntKey('icao');
            expect('model should be saved', $model->save())->true();
        });
    }

    public function testCreateNewAircraftWithoutICAO()
    {
        $model = new Aircraft();
        $model->name = 'Test aircraft';

        $this->specify('Aircraft should not be created with specified Name only', function () use ($model) {
            expect('model should not validate new Aircraft', $model->validate())->false();
            expect('model should contain ICAO error', $model->errors)->hasKey('icao');
            expect('model should not be saved', $model->save())->false();
        });
    }

    public function testCreateNewAircraftWithoutName()
    {
        $model = new Aircraft();
        $model->icao = 'TAIR';

        $this->specify('Aircraft should not be created with specified ICAO only', function () use ($model) {
            expect('model should not validate new Aircraft', $model->validate())->false();
            expect('model should contain Name error', $model->errors)->hasKey('name');
            expect('model should not be saved', $model->save())->false();
        });
    }
}