<?php

namespace common\models\query;

use common\models\ProjectUser;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ProjectUser]].
 *
 * @see ProjectUser
 */
class ProjectUserQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return ProjectUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProjectUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byUser($userId, $role = null)
    {
        $this->andWhere(['user_id' => $userId]);

        if ($role) {
            $this->andWhere(['role' => $role]);
        }

        return $this;
    }
}
