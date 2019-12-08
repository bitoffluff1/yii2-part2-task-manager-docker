<?php

use common\models\Project;
use common\models\ProjectUser;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Project */
/* @var $form yii\widgets\ActiveForm */
/* @var $usernames */

?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(Project::STATUS_LABELS) ?>

    <?= $form->field($model, Project::RELATION_PROJECT_USERS)->widget(MultipleInput::class, [
            //https://github.com/unclead/yii2-multiple-input
        'max' => 10,
        'min' => 0,
        'addButtonPosition' => MultipleInput::POS_HEADER,
        'columns' => [
            [
                'name'  => 'project_id',
                'type'  => 'hiddenInput',
                'defaultValue' => $model->id,
            ],
            [
                'name'  => 'user_id',
                'type'  => 'dropDownList',
                'title' => 'Пользователь',
                'items' => $usernames,
            ],
            [
                'name'  => 'role',
                'type'  => 'dropDownList',
                'title' => 'Роль',
                'items' => ProjectUser::ROLES_LABELS,
            ],
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
