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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css',
        'vendor/open-iconic/font/css/open-iconic-bootstrap.min.css',
        'vendor/bootstrap-select/css/bootstrap-select.min.css',
        'vendor/toastr/toastr.min.css',
        'vendor/flatpickr/flatpickr.min.css',
        ['css/theme.min.css', 'data-skin' => 'default'],
        ['css/theme-dark.min.css', 'data-skin' => 'dark'],
        'css/custom.css',
        'css/upload_image.css',
        'css/custom-header.css',
        'css/frontend.css',
        'css/adminCustom.css',
        'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css'

    ];
    public $js = [
        'vendor/toastr/toastr.min.js',
        'vendor/popper.js/popper.min.js',
        'vendor/bootstrap/js/bootstrap.min.js',
        'vendor/bootstrap/js/bootstrap.bundle.min.js',
        'vendor/pace-progress/pace.min.js',
        'vendor/stacked-menu/js/stacked-menu.min.js',
        'vendor/perfect-scrollbar/perfect-scrollbar.min.js',
        'vendor/flatpickr/flatpickr.min.js',
        'vendor/bootstrap-select/js/bootstrap-select.min.js',
        'vendor/typeahead.js/typeahead.bundle.min.js',
        'js/theme.min.js',
        'js/custom.js',
        'https://cdn.jsdelivr.net/npm/flatpickr'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
