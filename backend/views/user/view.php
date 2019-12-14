<?php

use common\models\ProjectUser;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $dataProviderProjectUser common\models\ProjectUser*/

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

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
            [
                'attribute' => 'avatar',
                'format' => 'raw',
                'value' => function(User $model){
                    return Html::img($model->getThumbUploadUrl('avatar', User::AVATAR_PREVIEW));
                },
            ],
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function (User $model) {
                    return User::STATUS_LABELS[$model->status];
                }
            ],
            'created_at:datetime',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProviderProjectUser,
        'columns' => [
            [
                'attribute' => 'project_id',
                'label' => 'Проекты',
                'value' => function (ProjectUser $model) {
                    return $model->project->title;
                }
            ],
            'role',
            [
                'format' => 'raw',
                'value' => function(ProjectUser $model){
                    return Html::a(
                        'Перейти в проект',
                        '/project/view?id=' . $model->project_id
                    );
                }
            ],
        ],
    ]); ?>

</div>
