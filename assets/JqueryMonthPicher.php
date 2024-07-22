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
class JqueryMonthPicher extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css',
        'stylesheets/stylesheet.css',
        'assets/month-picker/demo/MonthPicker.min.css',
        'assets/month-picker/demo/examples.css',

    ];
    public $js = [
        'https://code.jquery.com/jquery-1.12.1.min.js',
        'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        'https://cdn.rawgit.com/digitalBush/jquery.maskedinput/1.4.1/dist/jquery.maskedinput.min.js',
        'assets/month-picker/demo/MonthPicker.min.js',
        'assets/month-picker/demo/examples.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
