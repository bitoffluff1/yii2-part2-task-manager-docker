<?php

namespace common\services;

use Yii;
use yii\base\Component;

class NotificationService extends Component
{
    public function sendAboutNewProjectRole($project, $user, $role)
    {
        Yii::$app->emailService->send(
            $user->email,
            'Изменена роль в проекте',
            'assignRole-html',
            'assignRole-text',
            ['project' => $project, 'user' => $user, 'role' => $role]
        );
    }
}
