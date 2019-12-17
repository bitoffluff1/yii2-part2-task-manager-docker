<?php

namespace common\models\query;

use common\models\Project;
use common\models\Task;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Task]].
 *
 * @see Task
 */
class TaskQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Task[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Task|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byUser($userId, $role = null)
    {
        $query = Project::find()->select('id')->byUser($userId, $role);

        return $this->andWhere(['project_id' => $query]);
    }
}
