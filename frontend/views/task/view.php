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
                    return $model->executor ? $model->executor->username : '-';
                }
            ],
            [
                'label' => 'Creator',
                'attribute' => 'creator_id',
                'format' => 'raw',
                'value' => function (Task $model) {
                    return $model->creator->username;
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
