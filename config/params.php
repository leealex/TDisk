<?php

use yii\helpers\ArrayHelper;

$config = [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
];

if (file_exists(__DIR__ . '/params.local.php')) {
    $config = ArrayHelper::merge($config, require __DIR__ . '/params.local.php');
}

return $config;