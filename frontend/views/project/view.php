<?php

use common\models\Project;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $creator common\models\User */
/* @var $updater common\models\User */
/* @var $roles array */
/* @var $manager boolean*/

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($manager): ?>
    <p>
        <?= Html::a('Create Task', ['task/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'description:ntext',
            [
                'label' => 'Status',
                'attribute' => 'active',
                'filter' => Project::STATUS_LABELS,
                'value' => function (Project $model) {
                    return Project::STATUS_LABELS[$model->active];
                }
            ],
            [
                'label' => 'Creator',
                'attribute' => 'creator_id',
                'value' => function (Project $model) {
                    return $model->creator->username;
                }
            ],
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

    <h3>Roles in this project:</h3>
    <?php foreach ($roles as $role):?>
       <p><?= "- $role" ?></p>
    <?php endforeach; ?>


    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>

</div>
