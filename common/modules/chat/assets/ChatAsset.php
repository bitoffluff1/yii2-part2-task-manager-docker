<?php

namespace common\modules\chat\assets;

use yii\web\AssetBundle;

class ChatAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/chat/web';
    public $css = [
    ];
    public $js = [
        'js/chat.js'
    ];
    public $depends = [];
}