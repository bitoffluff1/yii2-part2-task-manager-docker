<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project_user".
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property string|null $role
 *
 * @property Project $project
 * @property User $user
 */
class ProjectUser extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id'], 'required'],
            [['project_id', 'user_id'], 'integer'],
            [['role'], 'string'],
            [['role'], 'in', 'range' => ['manager', 'developer', 'tester']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'role' => 'Role',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return Query the active query used by this AR class.
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
}
