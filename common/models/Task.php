<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int|null $project_id
 * @property int|null $executor_id
 * @property int|null $started_at
 * @property int|null $completed_at
 * @property int $creator_id
 * @property int|null $updater_id
 * @property int $created_at
 * @property int|null $updated_at
 *
 * @property User $executor
 * @property User $creator
 * @property User $updater
 */
class Task extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'creator_id', 'created_at'], 'required'],
            [['description'], 'string'],
            [['project_id', 'executor_id', 'started_at', 'completed_at', 'creator_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title', 'description'], 'trim'],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['executor_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updater_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'project_id' => 'Project ID',
            'executor_id' => 'Executor ID',
            'started_at' => 'Начало',
            'completed_at' => 'Окончание',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::class, ['id' => 'executor_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::class, ['id' => 'updater_id']);
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
