<?php

use common\models\Task;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $isManager */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($isManager): ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
        </p>
    <?php endif ?>

    <?php if (Yii::$app->taskService->canTake($model, Yii::$app->user->identity)): ?>
        <p>
            <?= Html::a(
                'Take to work',
                ['task/take', 'id' => $model->id],
                [
                    'class' => 'btn btn-success',
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to take this task?'),
                    'data-method' => 'post',
                ]
            ) ?>
        </p>
    <?php endif ?>

    <?php if (Yii::$app->taskService->canComplete($model, Yii::$app->user->identity)): ?>
        <p>
            <?= Html::a(
                'Complete',
                ['task/complete', 'id' => $model->id],
                [
                    'class' => 'btn btn-success',
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to complete this task?'),
                    'data-method' => 'post',
                ]
            ) ?>
        </p>
    <?php endif ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'description:ntext',
            [
                'label' => 'Project',
                'attribute' => 'project_id',
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
                'format' => 'raw',
                'value' => function (Task $model) {
                    return $model->executor ? Html::a(
                        $model->executor->username,
                        ['user/view', 'id' => $model->executor_id]
                    ) : '-';
                }
            ],
            [
                'label' => 'Creator',
                'attribute' => 'creator_id',
                'format' => 'raw',
                'value' => function (Task $model) {
                    return Html::a(
                        $model->creator->username,
                        ['user/view', 'id' => $model->creator_id]
                    );

                }
            ],
            'started_at:date',
            'completed_at:date',
        ],
    ]) ?>

    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>

</div>
