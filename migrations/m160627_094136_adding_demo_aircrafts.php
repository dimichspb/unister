<?php

use yii\db\Migration;
use app\models\Aircraft;

class m160627_094136_adding_demo_aircrafts extends Migration
{
    public function up()
    {
        $demoAircraft1 = new Aircraft();
        $demoAircraft1->name = 'Boeing 737-200';
        $demoAircraft1->icao = 'B732';
        $demoAircraft1->save();

        $demoAircraft2 = new Aircraft();
        $demoAircraft2->name = 'Airbus A318';
        $demoAircraft2->icao = 'A318';
        $demoAircraft2->save();

    }

    public function down()
    {
        $demoAircraft1 = Aircraft::findByICAO('B732');
        $demoAircraft1->delete();

        $demoAircraft2 = Aircraft::findByICAO('A318');
        $demoAircraft2->delete();
    }
}
