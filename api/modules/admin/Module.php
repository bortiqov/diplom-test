<?php

namespace api\modules\admin;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;

/**
 * v1 module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'api\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'except' => [
                'default/*',
                'user/login',
                '*/options',
            ],
            'optional' => [
            ],
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => static::allowedDomains(),
                'Access-Control-Request-Method' => ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'OPTIONS', 'DELETE'],
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Expose-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Allow-Methods' => ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'OPTIONS', 'DELETE'],
                'Access-Control-Allow-Headers' => ['Authorization', 'X-Requested-With', 'content-type'],
            ],
        ];

        return $behaviors;
    }

    /**
     * @var array
     */
    public static $urlRules = [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'admin/default',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',

                'GET' => 'default/index',
                'GET clear-cache' => 'default/clear-cache',
            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'admin/post',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS    ' => 'options',

                'GET' => 'index',
                'GET <id:\d+>' => 'show',

            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'admin/banner',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',

                'GET' => 'index',

                'OPTIONS <id:\d+>' => 'options',

                'GET <id:\d+>' => 'view',
                'POST' => 'create',
                'POST <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',

            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/partner',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'OPTIONS <id:\d+>' => 'options',

                'GET' => 'index',
                'GET <id:\d+>' => 'view',
                'POST' => 'create',
                'POST <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',

            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/doctor',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS' => 'options',
                'OPTIONS <id:\d+>' => 'options',

                'GET' => 'index',
                'GET <id:\d+>' => 'view',
                'POST' => 'create',
                'POST <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',

            ]
        ],

        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/page',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',

                'GET' => 'index',

                'GET <id:\d+>' => 'view',

                'GET <slug:\S+>' => 'page',
                'OPTIONS <slug:\S+>' => 'options',
            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/user',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',

                'POST login' => 'login',
                'OPTIONS login' => 'options',

                'POST register' => 'register',
                'OPTIONS register' => 'options',

                'POST upload-image' => 'upload-image',
                'OPTIONS upload-image' => 'options',

                'POST update' => 'update',
                'OPTIONS update' => 'update',

                'POST confirm-email' => 'confirm-email',
                'OPTIONS confirm-email' => 'options',

                'GET get-me' => 'get-me',
                'OPTIONS get-me' => 'options',
            ]
        ],
    ];

    /**
     * @return array
     */
    public static function allowedDomains()
    {
        return [
            '*',
        ];
    }
}
