<?php

namespace frontend\modules\api\models;

class Task extends \common\models\Task
{
    public function fields()
    {
        return [
            'id',
            'title',
            'description_short' => function () {
                return mb_substr($this->description, 0, 50);
            }
        ];
    }

    public function extraFields()
    {
        return [
            self::RELATION_PROJECT => function ($model) {
                return $this->project;
            }
        ];
    }
}