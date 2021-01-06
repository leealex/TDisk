<?php

use yii\helpers\ArrayHelper;

$config = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

if (file_exists(__DIR__ . '/db.local.php')) {
    $config = ArrayHelper::merge($config, require __DIR__ . '/db.local.php');
}

return $config;
