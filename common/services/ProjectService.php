<?php

namespace common\services;

use common\models\Project;
use common\models\ProjectUser;
use common\models\User;
use common\services\events\AssignRoleEvent;
use yii\base\Component;

class ProjectService extends Component
{
    const EVENT_ASSIGN_ROLE = 'assignRole';

    public function assignRole(Project $project, User $user, $role)
    {
        $event = new AssignRoleEvent();

        $event->project = $project;
        $event->user = $user;
        $event->role = $role;
        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
    }

    /**
     * Возвращает список ролей пользователя в определенном проекте
     *
     * @param Project $project
     * @param User $user
     * @return array
     */
    public function getRoles(Project $project, User $user)
    {
        $projectUser = ProjectUser::find()
            ->where(['project_id' => $project->id])
            ->andWhere(['user_id' => $user->id])->all();

        $roles = [];
        foreach ($projectUser as $curr => $item) {
            $roles[$curr] = $item->role;
        }

        return $roles;
    }

    /**
     * Проверяет есть ли у пользователя определеная роль в проекте
     *
     * @param Project $project
     * @param User $user
     * @param $role
     * @return boolean
     */
    public function hasRole($project, $user, $role)
    {
        $projectUser = ProjectUser::find()
            ->where(['project_id' => $project->id])
            ->andWhere(['user_id' => $user->id])->andWhere(['role' => $role])->all();

        if ($projectUser) {
            return true;
        }
        return false;
    }
}
