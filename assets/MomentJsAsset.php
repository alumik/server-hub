<?php

namespace app\assets;

use yii\web\AssetBundle;

class MomentJsAsset extends AssetBundle
{
    public $sourcePath = '@bower';

    public $js = [
        'momentjs/moment.js'
    ];
}
