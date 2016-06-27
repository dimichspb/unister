<?php

use yii\db\Migration;
use app\models\User;

class m160627_074944_adding_demo_users extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $demoAdmin = new User();
        $demoAdmin->username = 'admin';
        $demoAdmin->setPassword('admin');
        $demoAdmin->email = 'admin@admin.com';
        $demoAdmin->save();

        $adminRole = $auth->getRole('admin');
        $auth->assign($adminRole, $demoAdmin->id);

        $demoManager = new User();
        $demoManager->username = 'manager';
        $demoManager->setPassword('manager');
        $demoManager->email = 'manager@manager.com';
        $demoManager->save();

        $managerRole = $auth->getRole('manager');
        $auth->assign($managerRole, $demoManager->id);

        $demoCustomer = new User();
        $demoCustomer->username = 'customer';
        $demoCustomer->setPassword('customer');
        $demoCustomer->email = 'customer@customer.com';
        $demoCustomer->save();

        $customerRole = $auth->getRole('customer');
        $auth->assign($customerRole, $demoCustomer->id);
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
