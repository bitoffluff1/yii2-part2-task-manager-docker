<?php

use common\modules\chat\Module;
use common\services\EmailService;
use common\services\events\AssignRoleEvent;
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'emailService' => [
            'class' => EmailService::class,
        ],
        'projectService' => [
            'class' => ProjectService::class,
            'on ' . ProjectService::EVENT_ASSIGN_ROLE => function (AssignRoleEvent $event) {
                Yii::$app->emailService->send(
                    $event->user->email,
                    'Изменена роль в проекте',
                    'assignRole-html',
                    'assignRole-text',
                    (array) $event
                    );
            }
        ],
    ],
    'modules' => [
        'chat' => [
            'class' => Module::class,
        ],
    ],
];
