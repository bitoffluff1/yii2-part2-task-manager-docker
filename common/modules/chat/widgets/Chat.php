<?php

namespace common\modules\chat\widgets;

use common\modules\chat\assets\ChatAsset;
use yii\bootstrap\Widget;

class Chat extends Widget
{
    public $port = 8080;

    public function init()
    {
        ChatAsset::register($this->view);
        $this->view->registerJsVar('wsPort', $this->port);
    }

    public function run()
    {
        return $this->render('chat');
    }
}
