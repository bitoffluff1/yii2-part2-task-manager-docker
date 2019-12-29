<?php


namespace common\models\query;


use common\models\User;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    public function onlyActive()
    {
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }

}