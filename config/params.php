<?php

use yii\helpers\ArrayHelper;

$params = [
    'adminEmail' => 'admin@example.com',
];

$paramsLocal = file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'params-local.php')? require ('params-local.php'): [];

return ArrayHelper::merge($params, $paramsLocal);
