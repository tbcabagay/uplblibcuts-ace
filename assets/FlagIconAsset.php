<?php
namespace app\assets;

use yii\web\AssetBundle;

class FlagIconAsset extends AssetBundle 
{
    public $sourcePath = '@bower/flag-icon-css'; 
    public $css = [ 
        'css/flag-icon.min.css',
    ];
    public $publishOptions = [
        'only' => [
            'flags/*/*',
            'css/*',
        ]
    ];
} 