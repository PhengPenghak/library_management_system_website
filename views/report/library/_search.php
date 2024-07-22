<?php

use app\assets\DateRangePickerAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BorrowBookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borrow-book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['details', 'id' => $id],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-3">
        </div>
        <div class="col-lg-3">
            <?= $form->field($searchModel, 'code') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['details', 'id' => $id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>