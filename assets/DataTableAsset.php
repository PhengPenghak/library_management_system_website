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
class DataTableAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css',
  ];
  public $js = [
    'vendor/datatables.net/js/jquery.dataTables.min.js',
    'vendor/datatables.net-responsive/js/dataTables.responsive.min.js',
    'vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js',
    'vendor/datatables.net/js/dataTables.bootstrap4.min.js',
    // 'vendor/datatables.net-responsive-bs4/js/dataTables.bootstrap.min.js',
  ];
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
  ];
}
