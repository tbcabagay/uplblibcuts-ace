<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AceAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $cssOptions = [
        'id' => 'main-ace-style',
        'class' => 'ace-main-stylesheet'
    ];
    public $css = [
        'css/ace.min.css',
    ];
    public $js = [
        'js/ace-elements.min.js',
        'js/ace.min.js',
    ];
}
