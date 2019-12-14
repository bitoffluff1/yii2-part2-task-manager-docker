<?php

use common\modules\chat\Module;
use common\services\EmailService;
use common\services\events\AssignRoleEvent;
use common\services\NotificationService;
use common\services\ProjectService;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'emailService' => [
            'class' => EmailService::class,
        ],
        'notificationService' => [
            'class' => NotificationService::class,
        ],
        'projectService' => [
            'class' => ProjectService::class,
            'on ' . ProjectService::EVENT_ASSIGN_ROLE => function (AssignRoleEvent $event) {
                Yii::$app->notificationService->sendAboutNewProjectRole($event->project, $event->user, $event->role);
            }
        ],
    ],
    'modules' => [
        'chat' => [
            'class' => Module::class,
        ],
    ],
];
