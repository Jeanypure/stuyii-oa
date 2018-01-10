<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'plugins/bootbox/bootbox.min.js',
        'plugins/app.min.js',
        'plugins/layer/layer.js',
        'plugins/chartjs/macarons.js',
        'plugins/chartjs/echart.min.js',
        'js/pageSize.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
