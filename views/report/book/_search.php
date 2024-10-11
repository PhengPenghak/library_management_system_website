<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DateRangePickerAsset;
use yii\helpers\Url;

DateRangePickerAsset::register($this);

$id = Yii::$app->request->get('id');

?>
<style>
    .blank_space_label {
        padding-top: 32px;
    }

    /* Custom dropdown styling */
    .form-control {
        border-radius: 0.25rem;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .125);
    }

    .btn-outline-danger,
    .btn-outline-success {
        border-radius: 0.25rem;
        padding: 0.75rem 1.25rem;
    }
</style>
<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['book', 'id' => $id],
        'options' => ['data-pjax' => true, 'id' => 'formblogSearch'],
        'method' => 'get',
    ]); ?>

    <div class="row">

        <div class="col-lg-4">
            <div class="float-right">
                <div class="blank_space_label"></div>
                <?php
                $borrowBookSearch = Yii::$app->request->get('BorrowBookSearch');
                $from_date = isset($borrowBookSearch['from_date']) ? $borrowBookSearch['from_date'] : '';
                $to_date = isset($borrowBookSearch['to_date']) ? $borrowBookSearch['to_date'] : '';
                $month_and_year = isset($borrowBookSearch['month_and_year']) ? $borrowBookSearch['month_and_year'] : '';
                ?>
                <?= Html::a('<i class="fas fa-file-pdf"></i> Export PDF', [
                    'report/export-pdf-book',

                ], [
                    'class' => 'btn btn-lg btn-outline-danger pr-3',
                ]) ?>

                <?= Html::a('<i class="fas fa-file-excel"></i> Export Excel', [
                    'report/export-excel-book',

                ], [
                    'class' => 'btn btn-lg btn-outline-success pr-3',
                ]) ?>
            </div>
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
    function cb(start, end) {
        $('#order__date__range span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        $("#borrowbooksearch-from_date").val(start.format('YYYY-MM-DD'));
        $("#borrowbooksearch-to_date").val(end.format('YYYY-MM-DD'));
    }

    $('#order__date__range').daterangepicker({
        startDate: start,
        endDate: end,
        opens: 'left',
        showDropdowns: true,
        locale: {
            format: 'YYYY-MM-DD',
            separator: ' to ',
            applyLabel: 'Apply',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom Range'
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        }
    }, cb);

    cb(start, end);

    $('#order__date__range').on('apply.daterangepicker', function(ev, picker) {
        $('#formblogSearch').submit();
    });

    $('#formblogSearch').on('change', function() {
        $(this).submit();
    });

JS;
$this->registerJs($script);
?>