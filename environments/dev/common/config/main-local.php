<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=ptt_shortener',
            'username' => '$DB_USERNAME',
            'password' => '$DB_PASSWORD',
            'charset' => 'utf8',
        ],
    ],
];
