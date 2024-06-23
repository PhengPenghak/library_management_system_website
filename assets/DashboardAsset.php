<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '',
    ];
    public $js = [
        'vendor/moment/min/moment.min.js',
        // 'vendor/easy-pie-chart/jquery.easypiechart.min.js',
        'vendor/chart.js/Chart.min.js',
        // 'js/dashboard-demo.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}