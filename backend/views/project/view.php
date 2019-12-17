<?php

use common\models\Project;
use common\models\ProjectUser;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $creator common\models\User */
/* @var $updater common\models\User */
/* @var $dataProviderProjectUser common\models\ProjectUser */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'active',
                'filter' => Project::STATUS_LABELS,
                'value' => function (Project $model) {
                    return Project::STATUS_LABELS[$model->active];
                }
            ],
            [
                'attribute' => 'creator_id',
                'value' => $creator->username,
            ],
            [
                'attribute' => 'updater_id',
                'value' => $updater->username,
            ],
            'created_at:datetime',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProviderProjectUser,
        'columns' => [
            [
                'attribute' => 'user_id',
                'label' => 'Пользователь',
                'value' => function (ProjectUser $model) {
                    return $model->user->username;
                }
            ],
            'role',
            [
                'format' => 'raw',
                'value' => function(ProjectUser $model){
                    return Html::a(
                        'Перейти',
                        '/user/view?id=' . $model->user_id
                    );
                }
            ],
        ],
    ]); ?>

    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>

</div>
