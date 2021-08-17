<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru',
    'components' => [
        'view' => [
            'class' => \common\components\View::class,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('DB_DSN'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
//            'enableSchemaCache' => true,
//            'enableQueryCache' => true,
//            'schemaCacheDuration' => 3600,
//            'queryCacheDuration' => 3600,
        ],
        'olddb' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('DB_DSN_OLD'),
            'username' => getenv('DB_USERNAME_OLD'),
            'password' => getenv('DB_PASSWORD_OLD'),
            'charset' => 'utf8',
//            'enableSchemaCache' => true,
//            'enableQueryCache' => true,
//            'schemaCacheDuration' => 3600,
//            'queryCacheDuration' => 3600,
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'forceTranslation' => true,
                    'enableCaching' => true,
                    'cachingDuration' => 3600,
                    'sourceLanguage' => 'en-US',
                    'sourceMessageTable' => 'source_message',
                    'messageTable' => 'message',
                    'on missingTranslation' => [
                        'common\modules\translation\components\EventHandlers',
                        'handleMissingTranslation',
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'encryption' => getenv('MAILER_ENCRYPTION'),
                'host' => getenv('MAILER_HOST'),
                'port' => getenv('MAILER_PORT'),
                'username' => getenv('MAILER_USERNAME'),
                'password' => getenv('MAILER_PASSWORD'),
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]
            ],
        ],
    ],
];
