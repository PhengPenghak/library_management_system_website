<?php

use app\assets\DateRangePickerAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

DateRangePickerAsset::register($this);

$base_url = Yii::getAlias("@web");
/** @var \app\components\Formater $formater */
$formater = Yii::$app->formater;

$this->registerJsFile(
    // 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.2/chart.min.js',
    'https://cdn.jsdelivr.net/npm/chart.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);

$this->title = 'PROINTIX - Admin Dashboard';
?>
<div class="site-index">
    <blockquote>
        <span class="d-block text-muted">Welcome to PROINTIX admin dashboard.</span>
        <footer>You can view all news update here.</footer>
    </blockquote>
</div>