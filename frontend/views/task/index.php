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
/* @var $manager */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                        '/project/view?id=' . $model->project_id
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
                            '/user/view?id=' . $model->executor_id
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
                    if ($model->creator) {
                        return Html::a(
                            $model->creator->username,
                            '/user/view?id=' . $model->creator_id
                        );
                    }
                    return '-';
                }
            ],
            [
                'format' => 'raw',
                'value' => function (Task $model) {
                    $user = User::findOne(Yii::$app->user->getId());
                    if (Yii::$app->taskService->canTake($model, $user)) {
                        return Html::a(
                            'Take to work',
                            '/task/take?id=' . $model->id
                        );
                    } else if(Yii::$app->taskService->canComplete($model, $user)){
                        return Html::a(
                            'Complete',
                            '/task/complete?id=' . $model->id
                        );
                    }
                    return '-';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => function (Task $model) {
                        $user = User::findOne(Yii::$app->user->getId());
                        return Yii::$app->taskService->canManage($model->project, $user);
                    },
                    'delete' => function (Task $model) {
                        $user = User::findOne(Yii::$app->user->getId());
                        return Yii::$app->taskService->canManage($model->project, $user);
                    },
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
