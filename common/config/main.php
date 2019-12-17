<?php

use common\services\EmailService;
use common\services\events\AssignRoleEvent;
use common\services\NotificationService;
use common\services\ProjectService;
use common\services\TaskService;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'taskService' => [
            'class' => TaskService::class,
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
            'class' => \common\modules\chat\Module::class,
        ],
        'comment' => [
            'class' => \yii2mod\comments\Module::class,
        ],
    ],
];
