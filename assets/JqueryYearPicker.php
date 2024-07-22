<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class JqueryYearPicker extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'assets/jquery-year-picker/css/yearpicker.css',
    ];
    public $js = [
        'https://code.jquery.com/jquery-3.4.1.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js',
        'assets/jquery-year-picker/js/yearpicker.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
