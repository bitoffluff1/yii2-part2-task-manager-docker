<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'on ' . \yii\web\User::EVENT_AFTER_LOGIN => function (\yii\web\UserEvent $event) {
                Yii::info('Success login ' . $event->identity->getId(), 'auth');
            },
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
                '/' => 'site/index',
                '/login' => 'site/login',
                '/logout' => 'site/logout',
                '/signup' => 'site/signup',

                '/users' => 'user/index',
                '/user/<id:\d+>' => 'user/view',
                '/user/profile' => 'user/profile',
                '/user/insert/<id:\d+>' => 'user/insert',
                '/user/update/<id:\d+>' => 'user/update',
                '/user/delete/<id:\d+>' => 'user/delete',

                '/projects' => 'project/index',
                '/project/<id:\d+>' => 'project/view',
                '/project/insert/<id:\d+>' => 'project/insert',
                '/project/update/<id:\d+>' => 'project/update',
                '/project/delete/<id:\d+>' => 'project/delete',

                '/tasks' => 'task/index',
                '/task/<id:\d+>' => 'task/view',
                '/task/insert/<id:\d+>' => 'task/insert',
                '/task/update/<id:\d+>' => 'task/update',
                '/task/delete/<id:\d+>' => 'task/delete',
            ],
        ],
    ],
    'params' => $params,
];
