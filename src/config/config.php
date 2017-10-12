<?php

return [
    'controllerMap' => [
        'migrate' => [
            'class'         => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                'console/migrations',
                dirname(__DIR__) . '/migrations',
            ],
        ],

    ],
];
