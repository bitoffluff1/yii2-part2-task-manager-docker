<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Profile';
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', 'update', ['class' => 'btn btn-primary']) ?>
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
        ],
    ]) ?>

</div>
