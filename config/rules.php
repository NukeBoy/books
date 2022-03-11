<?php

use yii\web\GroupUrlRule;

return [
    [
        'class'  => GroupUrlRule::class,
        'prefix' => 'books',
        'rules'  => [
            'GET '            => 'index',
            'GET <id>'    => 'view',
            'POST '           => 'create',
            'PUT <id>'    => 'update',
            'DELETE <id:\w+>' => 'delete',
        ],
    ],
    [
        'class'  => GroupUrlRule::class,
        'prefix' => 'authors',
        'rules'  => [
//            'GET statistic'   => 'statistic',
            'GET '            => 'index',
            'GET <id:[a-fA-F0-9-]+>'    => 'view',
            'POST '           => 'create',
            'PUT <id>'    => 'update',
            'DELETE <id>' => 'delete',
        ],
    ],
];
