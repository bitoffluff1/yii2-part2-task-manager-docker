<?php

use common\models\Project;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

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
            'active',
            [
                'label' => 'Создал',
                'attribute' => 'creator_id',
                'value' => function (Project $model) {
                    $user = User::findOne($model->creator_id);
                    return $user->username;
                }
            ],
            [
                'label' => 'Изменил',
                'attribute' => 'updater_id',
                'value' => function (Project $model) {
                    $user = User::findOne($model->creator_id);
                    return $user->username;
                }
            ],
            [
                'attribute' => 'created_at',
                'format'=> ['date'],
            ],
            [
                'attribute' => 'updated_at',
                'format'=> ['date'],
            ],
        ],
    ]) ?>

    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>

</div>
