<?php

namespace app\assets;

use yii\web\AssetBundle;

class SweetAlert2Asset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css'
    ];
    /**
     * @var array
     */
    public $js = [
        'vendor/sweetalert2/sweetalert2.all.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
