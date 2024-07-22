<?php

use yii\helpers\Html;
use yii\helpers\Url;

$action = Yii::$app->controller->action->id;
if (!$modelHeader->isNewRecord) {
    $listArr = [
        [
            'active' => ['detail'],
            'action' => 'detail',
            'label' => 'ព័ត៌មានអ្នកទទួលសៀវភៅ'
        ],
        [
            'active' => ['create-book-distribution'],
            'action' => 'create-book-distribution',
            'label' => 'ទទួលសៀវភៅ'
        ],

        [
            'active' => ['update-book-distribution'],
            'action' => 'update-book-distribution',
            'label' => 'សងសៀវភៅ'
        ],

    ];
}

?>

<ul class="nav nav-tabs card-header-tabs">
    <?php
    if (!$modelHeader->isNewRecord) {
        foreach ($listArr as $key => $value) {
            $active = in_array($action, $value['active']) ? 'active' : '';
            echo "<li>" . Html::a($value['label'], ['book-distribution/' . $value['action'], 'id' => $modelHeader->id], ['class' => 'nav-link ' . $active]) . "</li>";
        }
    } else {
        echo "<li>" . Html::a('ព័ត៌មានអ្នកខ្ចីសៀវភៅ', '#', ['class' => 'nav-link active prevent-default']) . "</li>";
    }
    ?>
</ul>