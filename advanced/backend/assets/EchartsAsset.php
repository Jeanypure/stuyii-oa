<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-01-09
 * Time: 17:15
 */

namespace backend\assets;
use yii\web\AssetBundle;


class EchartsAsset extends AssetBundle
{
    public $sourcePath = '@bower/echarts/dist';
    public $js = [
        'echarts.js',
    ];
}