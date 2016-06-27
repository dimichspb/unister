<?php

use yii\helpers\ArrayHelper;

$dbConfig = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

$dbLocalConfig = file_exists('db-local.php')? require ('db-local.php'): [];

return ArrayHelper::merge($dbConfig, $dbLocalConfig);
