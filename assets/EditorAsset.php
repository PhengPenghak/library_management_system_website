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
class EditorAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    // 'vendor/summernote/summernote-bs4.min.css',
    'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css'
  ];
  public $js = [
    // 'vendor/summernote/summernote-bs4.min.js',
    'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js'
  ];
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
  ];
}
