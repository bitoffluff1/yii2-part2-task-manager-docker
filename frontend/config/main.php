<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'on ' . \yii\web\User::EVENT_AFTER_LOGIN => function (\yii\web\UserEvent $event) {
                Yii::info('Success login ' . $event->identity->getId(), 'auth');
            },
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['auth'],
                    'logFile' => '@runtime/logs/auth.log',
                    'logVars' => [],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
               ['class' => 'yii\rest\UrlRule', 'controller' => 'api/project'],
               ['class' => 'yii\rest\UrlRule', 'controller' => 'api/task'],

                '<controller:(project|task|user)>/<id:\d+>/<action:(create|update|delete)>' => '<controller>/<action>',
                '<controller:(project|task|user)>/<id:\d+>' => '<controller>/view',
                '<controller:(project|task|user)>s' => '<controller>/index',

                '/' => 'site/index',
                '/login' => 'site/login',
                '/logout' => 'site/logout',
                '/signup' => 'site/signup',
            ],
        ],
    ],
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Module',
        ],
    ],
    'params' => $params,
];
