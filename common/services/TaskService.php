<?php

namespace common\services;

use common\models\Project;
use common\models\Task;
use common\models\User;
use yii\base\Component;

class TaskService extends Component
{
    /**
     * Проверяет может ли пользователь управлять задачами в проекте
     * может если он менеджер в проекте, используйте hasRole() из ProjectService
     *
     * @param Project $project
     * @param User $user
     */
    public function canManage(Project $project, User $user)
    {

    }

    /**
     * Проверяет может ли пользователь взять задачу в работу
     * может если он девелопер в проекте (используйте hasRole() из ProjectService)
     * и поле executor_id у задачи пустое
     *
     * @param Task $task
     * @param User $user
     */
    public function canTake(Task $task, User $user)
    {

    }

    /**
     * Проверяет может ли пользователь закончить работу
     * может если ид пользователя в поле executor_id у задачи и поле completed_at у задачи пустое.
     *
     * @param Task $task
     * @param User $user
     */
    public function canComplete(Task $task, User $user)
    {

    }

    /**
     * взять задачу в работу - изменяем start_at и executor_id и возвращаем результат сохранения.
     *
     * @param Task $task
     * @param User $user
     */
    public function takeTask(Task $task, User $user)
    {

    }

    /**
     * закончить работу - изменяем completed_at и возвращаем результат сохранения
     *
     * @param Task $task
     */
    public function completeTask(Task $task)
    {

    }


}
