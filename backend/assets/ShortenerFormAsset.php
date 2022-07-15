<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for page with ShortenerForm.
 */
class ShortenerFormAsset extends AssetBundle
{
    public $basePath = '@webroot/ShortenerFormAsset';
    public $baseUrl = '@web/ShortenerFormAsset';
    public $css = [
        'main.css'
    ];
    public $js = [
        'main.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
