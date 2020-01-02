<?php

use common\models\Project;
use common\models\Task;
use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $projectsTitles Project[] */
/* @var $activeUsers User[] */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'description:ntext',
            [
                'label' => 'Project',
                'attribute' => 'project_id',
                'filter' => $projectsTitles,
                'format' => 'raw',
                'value' => function (Task $model) {
                    return Html::a(
                        $model->project->title,
                        ['project/view', 'id' => $model->project_id]
                    );
                }
            ],
            [
                'label' => 'Executor',
                'attribute' => 'executor_id',
                'filter' => $activeUsers,
                'format' => 'raw',
                'value' => function (Task $model) {
                    if ($model->executor) {
                        return Html::a(
                            $model->executor->username,
                            ['user/view', 'id' => $model->executor_id]
                        );
                    }
                    return '-';
                }
            ],
            [
                'label' => 'Creator',
                'attribute' => 'creator_id',
                'filter' => $activeUsers,
                'format' => 'raw',
                'value' => function (Task $model) {
                    return Html::a(
                        $model->creator->username,
                        ['user/view', 'id' => $model->creator_id]
                    );
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {take} {complete}',
                'visibleButtons' => [
                    'update' => function (Task $model) {
                        return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
                    },
                    'delete' => function (Task $model) {
                        return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
                    },
                    'take' => function (Task $model) {
                        return Yii::$app->taskService->canTake($model, Yii::$app->user->identity);
                    },
                    'complete' => function (Task $model) {
                        return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
                    },
                ],
                'buttons' => [
                    'take' => function ($url, Task $model) {
                        return Html::a(
                            'Take to work',
                            ['task/take', 'id' => $model->id],
                            [
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to take this task?'),
                                'data-method' => 'post',
                            ]
                        );
                    },
                    'complete' => function ($url, Task $model) {
                        return Html::a(
                            'Complete',
                            ['task/complete', 'id' => $model->id],
                            [
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to complete this task?'),
                                'data-method' => 'post',
                            ]
                        );
                    }
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
