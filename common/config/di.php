<?php

use yii\di\Instance;
use \backend\models\HashUrl;

return [
    'definitions' => [
        'baseOnMillisecondHashGeneratorStrategy' => [
            ['class' => 'backend\components\HashGeneratorStrategy\BaseOnMillisecondHashGeneratorStrategy'],
            [
                'size' => 5,
                'base' => microtime(true) * 1000
            ]
        ],
        'baseOnIdHashGeneratorStrategy' => [
            ['class' => 'backend\components\HashGeneratorStrategy\BaseOnIdHashGeneratorStrategy'],
            [
                'size' => 5,
                'base' => function() {
                    return (int) HashUrl::find()->max('hash_url_id');
                },
            ]
        ],
        'shortenerUrlProvider' => [
            ['class' => 'backend\components\ShortenerUrlProvider'],
            [
                '',
                Instance::of('baseOnMillisecondHashGeneratorStrategy')
            ]
        ],
        'trafficRegistrar' => [
            ['class' => 'common\components\TrafficRegistrar\TrafficRegistrar'],
            ['', '']
        ],
    ],
];