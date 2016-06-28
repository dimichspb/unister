<?php
namespace tests\codeception\unit\models;

use app\models\City;
use Yii;
use yii\codeception\TestCase;
use app\models\LoginForm;
use Codeception\Specify;

class CityTest extends TestCase
{
    use Specify;

    protected function tearDown()
    {
        if ($model = City::findByIATA('TCT')) {
            $model->delete();
        }
        parent::tearDown();
    }

    public function testCreateNewCity()
    {
        $model = new City();
        $model->iata = 'TCT';
        $model->name = 'Test city';

        $this->specify('City should be created with specified Name and IATA', function () use ($model) {
            expect('model should validate new City', $model->validate())->true();
            expect('model should not contain errors with Name', $model->errors)->hasntKey('name');
            expect('model should not contain errors with IATA', $model->errors)->hasntKey('iata');
            expect('model should be saved', $model->save())->true();
        });
    }

    public function testCreateNewCityWithoutIATA()
    {
        $model = new City();
        $model->name = 'Test city';

        $this->specify('City should not be created with specified Name only', function () use ($model) {
            expect('model should not validate new City', $model->validate())->false();
            expect('model should contain IATA error', $model->errors)->hasKey('iata');
            expect('model should not be saved', $model->save())->false();
        });
    }

    public function testCreateNewCityWithoutName()
    {
        $model = new City();
        $model->iata = 'TCT';

        $this->specify('City should not be created with specified IATA only', function () use ($model) {
            expect('model should not validate new City', $model->validate())->false();
            expect('model should contain Name error', $model->errors)->hasKey('name');
            expect('model should not be saved', $model->save())->false();
        });
    }
}