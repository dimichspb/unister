<?php

use yii\helpers\ArrayHelper;

$dbConfig = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'enableSchemaCache' => true,
    'enableQueryCache' => true,
];

$dbConfigLocal = file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'db-local.php')? require ('db-local.php'): [];

return ArrayHelper::merge($dbConfig, $dbConfigLocal);

