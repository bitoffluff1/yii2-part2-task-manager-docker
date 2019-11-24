<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project`.
 */
class m191123_195804_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue('0'),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk_project_user_1',
            'project', 'creator_id',
            'user', 'id',
            'restrict', 'cascade'
        );

        $this->addForeignKey(
            'fk_project_user_2',
            'project', 'updater_id',
            'user', 'id',
            'restrict', 'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('project');
    }
}
