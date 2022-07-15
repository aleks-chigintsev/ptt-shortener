<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'container' => require __DIR__ . '/di.php',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=ptt_shotener',
            'username' => '$DB_USERNAME',
            'password' => '$DB_PASSWORD',
            'charset' => 'utf8',
            'tablePrefix' => 'ab54f3equ8_',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
