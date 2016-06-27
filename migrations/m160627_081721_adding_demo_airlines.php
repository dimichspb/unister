<?php

use yii\db\Migration;
use app\models\Airline;

class m160627_081721_adding_demo_airlines extends Migration
{
    public function up()
    {
        $demoAirline1 = new Airline();
        $demoAirline1->name = 'easyJet';
        $demoAirline1->icao = 'EZY';
        $demoAirline1->save();

        $demoAirline2 = new Airline();
        $demoAirline2->name = 'Ryanair';
        $demoAirline2->icao = 'RYR';
        $demoAirline2->save();

        $demoAirline3 = new Airline();
        $demoAirline3->name = 'Germanwings';
        $demoAirline3->icao = 'GWI';
        $demoAirline3->save();
    }

    public function down()
    {
        $demoAirline1 = Airline::findByICAO('EZY');
        $demoAirline1->delete();
        $demoAirline2 = Airline::findByICAO('RYR');
        $demoAirline2->delete();
        $demoAirline3 = Airline::findByICAO('GWI');
        $demoAirline3->delete();
    }

}
