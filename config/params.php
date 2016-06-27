<?php

use yii\helpers\ArrayHelper;

$params = [
    'adminEmail' => 'admin@example.com',
];

$paramsLocal = file_exists('params-local.php')? require ('params-local.php'): [];

return ArrayHelper::merge($params, $paramsLocal);
