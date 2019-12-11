<?php

namespace common\services;

use Yii;
use yii\base\Component;

class EmailService extends Component
{
    public function send($to, $subject, $viewHTML, $viewText, $data)
    {
        Yii::$app
            ->mailer
            ->compose(
                ['html' => $viewHTML, 'text' => $viewText],
                //['user' => $event->user, 'project' => $event->project, ... ]
                (array)$data
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}
