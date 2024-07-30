<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DateRangePickerAsset;

DateRangePickerAsset::register($this);
$id = Yii::$app->request->get('id');
?>

<style>
    .blank_space_label {
        padding-top: 32px;
    }
</style>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['details', 'id' => $id],
        'options' => ['data-pjax' => true, 'id' => 'formblogSearch'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-4">
            <label>Date Range</label>
            <div id="order__date__range" style="cursor: pointer;" class="form-control">
                <i class="fas fa-calendar text-muted"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down text-muted float-right"></i>
            </div>
            <?= $form->field($model, 'from_date')->hiddenInput(['id' => 'borrowbooksearch-from_date'])->label(false) ?>
            <?= $form->field($model, 'to_date')->hiddenInput(['id' => 'borrowbooksearch-to_date'])->label(false) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS

var is_filter = $("#borrowbooksearch-from_date").val() != '' ? true : false;

if (!is_filter) {
    var start = moment().startOf('week');
    var end = moment();
} else {
    var start = moment($("#borrowbooksearch-from_date").val());
    var end = moment($("#borrowbooksearch-to_date").val());
}

function cb(start, end) {
    $('#order__date__range span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    $("#borrowbooksearch-from_date").val(start.format('YYYY-MM-DD'));
    $("#borrowbooksearch-to_date").val(end.format('YYYY-MM-DD'));
}

$('#order__date__range').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'This Week': [moment().startOf('week'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

cb(start, end);

$('#order__date__range').on('apply.daterangepicker', function(ev, picker) {
    $('#formblogSearch').submit();
});

JS;
$this->registerJs($script);
?>