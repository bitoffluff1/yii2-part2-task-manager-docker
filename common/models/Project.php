<?php

namespace common\models;

use common\models\query\ProjectQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $active
 * @property int $creator_id
 * @property int $updater_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $creator
 * @property User $updater
 * @property ProjectUser[] $projectUsers
 * @property Task[] $tasks
 */
class Project extends ActiveRecord
{
    const RELATION_CREATOR = 'creator';
    const RELATION_UPDATER = 'updater';
    const RELATION_PROJECT_USERS = 'projectUsers';
    const RELATION_TASKS = 'tasks';

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const STATUSES = [
        self::STATUS_INACTIVE,
        self::STATUS_ACTIVE,
    ];

    const STATUS_LABELS = [
        self::STATUS_INACTIVE => 'Не активный',
        self::STATUS_ACTIVE => 'Активный'
    ];

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id',
            ],
            TimestampBehavior::class,
            'saveRelations' => [
                'class' => SaveRelationsBehavior::class,
                'relations' => [self::RELATION_PROJECT_USERS],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['title', 'description'], 'trim'],
            [['title'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 255],

            [['active'], 'in', 'range' => self::STATUSES],
            [['active'], 'default', 'value' => self::STATUS_ACTIVE],

            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updater_id' => 'id']],
        ];
    }

    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    public function getUpdater()
    {
        return $this->hasOne(User::class, ['id' => 'updater_id']);
    }


    public function getProjectUsers()
    {
        return $this->hasMany(ProjectUser::class, ['project_id' => 'id']);
    }


    public function getTasks()
    {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }

    /**
     * @return array [id1=>role1, id2->role2...]
     */
    public function getUserRoles()
    {
        return $this->getProjectUsers()->select('role')->indexBy('user_id')->column();
    }

    public static function getAllProjectsTitles()
    {
        $projects = Project::find()->select(['id', 'title'])->all();

        return ArrayHelper::map($projects, 'id', 'title');
    }

    /**
     * {@inheritdoc}
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }
}
