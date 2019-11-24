<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m191123_194128_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'project_id' => $this->integer(),
            'executor_id' => $this->integer(),
            'started_at' => $this->integer(),
            'completed_at' => $this->integer(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk_task_user_1',
            'task', 'executor_id',
            'user', 'id',
            'restrict', 'cascade'
        );

        $this->addForeignKey(
            'fk_task_user_2',
            'task', 'creator_id',
            'user', 'id',
            'restrict', 'cascade'
        );

        $this->addForeignKey(
            'fk_task_user_3',
            'task', 'updater_id',
            'user', 'id',
            'restrict', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task');
    }
}
