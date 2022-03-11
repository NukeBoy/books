<?php

use yii\caching\DummyCache;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
$config = [
    'id'         => 'basic-tests',
    'basePath'   => dirname(__DIR__),
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language'   => 'en-US',
    'components' => [
        'mongodb'      => require 'mongodb.php',
        'mailer'       => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => require 'rules.php',
        ],
        'user'         => [
            'identityClass' => 'app\models\User',
        ],
        'request'      => [
            'cookieValidationKey'  => 'test',
            'enableCsrfValidation' => false,
        ],
        'cache'        => [
            'class' => DummyCache::class
        ]
    ],
    'params'     => $params,
];

return $config;

