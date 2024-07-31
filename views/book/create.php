<?php

use app\widgets\Breadcrumbs;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = 'បញ្ចូលសៀវភៅថ្មី';

?>
<?= Breadcrumbs::widget([
    'homeLink' => Yii::$app->params['breadcrumbs']['homeLink'],
    'links' => [
        ['label' => 'ព័ត៌មានទូទៅ', 'url' =>  Yii::$app->homeUrl],
        ['label' => 'សៀវភៅ', 'url' => ['index']],
        ['label' => 'បញ្ចូលសៀវភៅថ្មី'],
    ],
]); ?>
<div class="book-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>