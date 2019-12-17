<?php

namespace common\models\query;

use common\models\Project;
use common\models\ProjectUser;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Project]].
 *
 * @see Project
 */
class ProjectQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Project[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Project|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byUser($userId, $role = null)
    {
        $query = ProjectUser::find()->select('project_id')->byUser($userId, $role);

        return $this->andWhere(['id' => $query]);
    }
}
