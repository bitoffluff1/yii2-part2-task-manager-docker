<?php

namespace common\services;

use common\models\Project;
use common\models\Task;
use common\models\User;
use yii\base\Component;
use yii\web\NotFoundHttpException;

class TaskService extends Component
{
    /**
     * Проверяет может ли пользователь управлять задачами в проекте
     * может если он менеджер в проекте, используйте hasRole() из ProjectService
     *
     * @param Project $project
     * @param User $user
     * @return array|\common\models\ProjectUser[]
     */
    public function canManage(Project $project, User $user)
    {
        return \Yii::$app->projectService->hasRole($project, $user, 'manager');
    }

    /**
     * Проверяет может ли пользователь взять задачу в работу
     * может если он девелопер в проекте (используйте hasRole() из ProjectService)
     * и поле executor_id у задачи пустое
     *
     * @param Task $task
     * @param User $user
     * @return boolean
     */
    public function canTake(Task $task, User $user)
    {
        return \Yii::$app->projectService->hasRole($task->project, $user, 'developer')
            && $task->executor_id === null;
    }

    /**
     * Проверяет может ли пользователь закончить работу
     * может если ид пользователя в поле executor_id у задачи и поле completed_at у задачи пустое.
     *
     * @param Task $task
     * @param User $user
     * @return boolean
     */
    public function canComplete(Task $task, User $user)
    {
        return $task->executor_id === $user->id
            && $task->completed_at === null;
    }

    /**
     * Взять задачу в работу
     * изменяем start_at и executor_id и возвращаем результат сохранения.
     *
     * @param Task $task
     * @param User $user
     * @return mixed
     */
    public function takeTask(Task $task, User $user)
    {
        if ($this->canTake($task, $user)) {
            $task->started_at = time();
            $task->executor_id = $user->id;

            if ($task->save()) {
                return $task;
            }
            return new NotFoundHttpException('Something went wrong.');
        }
        return new NotFoundHttpException('The requested action is not available.');
    }

    /**
     * Закончить работу
     * изменяем completed_at и возвращаем результат сохранения
     *
     * @param Task $task
     * @param User $user
     * @return mixed
     */
    public function completeTask(Task $task, User $user)
    {
        if ($this->canComplete($task, $user)) {
            $task->completed_at = time();

            if ($task->save()) {
                return $task;
            }
            return new NotFoundHttpException('Something went wrong.');
        }
        return new NotFoundHttpException('The requested action is not available.');
    }
}
