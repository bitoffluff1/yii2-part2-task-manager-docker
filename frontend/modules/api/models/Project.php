<?php

namespace frontend\modules\api\models;

class Project extends \common\models\Project
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
            self::RELATION_TASKS => function ($model) {
                return $this->tasks;
            }
        ];
    }
}