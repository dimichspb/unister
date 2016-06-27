<?php

use yii\db\Migration;
use app\models\City;

class m160627_092040_adding_demo_cities extends Migration
{
    public function up()
    {
        $demoCity1 = new City();
        $demoCity1->name = 'Berlin';
        $demoCity1->iata = 'BER';
        $demoCity1->save();

        $demoCity2 = new City();
        $demoCity2->name = 'Leipzig';
        $demoCity2->iata = 'LEJ';
        $demoCity2->save();

        $demoCity3 = new City();
        $demoCity3->name = 'Munich';
        $demoCity3->iata = 'MUC';
        $demoCity3->save();

        $demoCity4 = new City();
        $demoCity4->name = 'Frankfurt';
        $demoCity4->iata = 'FRA';
        $demoCity4->save();

    }

    public function down()
    {
        $demoCity1 = City::findByIATA('BER');
        $demoCity1->delete();
        $demoCity2 = City::findByIATA('LEJ');
        $demoCity2->delete();
        $demoCity3 = City::findByIATA('MUC');
        $demoCity3->delete();
        $demoCity4 = City::findByIATA('FRA');
        $demoCity4->delete();
    }
}
