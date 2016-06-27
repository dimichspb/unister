<?php

use yii\db\Migration;
use app\models\User;

class m160627_074944_adding_demo_users extends Migration
{
    public function up()
    {
        $demoAdmin = new User();
        $demoAdmin->username = 'admin';
        $demoAdmin->setPassword('admin');
        $demoAdmin->email = 'admin@admin.com';
        $demoAdmin->save();

        $demoManager = new User();
        $demoManager->username = 'manager';
        $demoManager->setPassword('manager');
        $demoManager->email = 'manager@manager.com';
        $demoManager->save();

        $demoCustomer = new User();
        $demoCustomer->username = 'customer';
        $demoCustomer->setPassword('customer');
        $demoCustomer->email = 'customer@customer.com';
        $demoCustomer->save();
    }

    public function down()
    {
        $demoAdmin = User::findByUsername('admin');
        $demoAdmin->delete();

        $demoManager = User::findByUsername('manager');
        $demoManager->delete();

        $demoCustomer = User::findByUsername('customer');
        $demoCustomer->delete();
    }
}
