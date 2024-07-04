<?php

use yii\helpers\Html;
use yii\helpers\Url;

$action = Yii::$app->controller->action->id;
if (!$modelHeader->isNewRecord) {
    $listArr = [
        [
            'active' => ['detail'],
            'action' => 'detail',
            'label' => 'Details'
        ],
        [
            'active' => ['borrow-book'],
            'action' => 'borrow-book',
            'label' => 'Borrower Book'
        ],

    ];
}

?>

<ul class="nav nav-tabs card-header-tabs">
    <?php
    if (!$modelHeader->isNewRecord) {
        foreach ($listArr as $key => $value) {
            $active = in_array($action, $value['active']) ? 'active' : '';
            echo "<li>" . Html::a($value['label'], ['borrower-book/' . $value['action'], 'id' => $modelHeader->id], ['class' => 'nav-link ' . $active]) . "</li>";
        }
    } else {
        echo "<li>" . Html::a('Details', '#', ['class' => 'nav-link active prevent-default']) . "</li>";
    }
    ?>
</ul>