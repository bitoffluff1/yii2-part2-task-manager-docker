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
            'tasks' => function ($model){
                return $this->tasks;
            }
        ];
    }
}