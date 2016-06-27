<?php

use yii\db\Migration;

class m160627_074010_adding_roles extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $customer = $auth->createRole('customer');
        $customer->description = 'Customer role';
        $auth->add($customer);

        // add "author" role and give this role the "createPost" permission
        $manager = $auth->createRole('manager');
        $manager->description = 'Manager role';
        $auth->add($manager);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $admin->description = 'Admin role';
        $auth->add($admin);
        $auth->addChild($admin, $customer);
        $auth->addChild($admin, $manager);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        
        $auth->removeAll();
    }
}
