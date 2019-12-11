<?php

/* @var $user common\models\User */
/* @var $project common\models\Project */
/* @var $role string */

?>
<div class="assign-role-email">
    <p>Привет, <?= $user->username ?></p>

    <p>В проекте <?= $project->title ?> тебе назначена роль <?= $role ?></p>

</div>
