<?php

namespace api\modules\v1;

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
    public $controllerNamespace = 'api\modules\v1\controllers';

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
                'options',
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
            'controller' => 'v1',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',

                'GET' => 'default/index',

                'GET clear-cache' => 'default/clear-cache',
            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/post',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',

                'GET' => 'index',

                'GET <id:\d+>' => 'show',

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

                'POST forgot-password' => 'forgot-password',
                'OPTIONS forgot-password' => 'options',

                'POST change-password' => 'change-password',
                'OPTIONS change-password' => 'options',

                'POST set-fcm-token' => 'set-fcm-token',
                'OPTIONS set-fcm-token' => 'options',

                'POST portfolio' => 'upload-portfolio',
                'OPTIONS portfolio' => 'options',

                'GET get-me' => 'get-me',
                'OPTIONS get-me' => 'options',

                'GET social' => 'social',
                'OPTIONS social' => 'options',
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
