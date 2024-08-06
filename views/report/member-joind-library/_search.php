<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DateRangePickerAsset;

DateRangePickerAsset::register($this);


$fromDate = Yii::$app->request->get('MemberJoinedLibrarySearch')['from_date'] ?? '';
$toDate = Yii::$app->request->get('MemberJoinedLibrarySearch')['to_date'] ?? '';
$typeJoined = Yii::$app->request->get('MemberJoinedLibrarySearch')['type_joined'] ?? '';




?>
<style>
    .blank_space_label {
        padding-top: 32px;
    }
</style>
<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['report/library'],
        'options' => ['data-pjax' => true, 'id' => 'formblogexperienceSearch'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-3">
            <label> កាលបរិច្ឆេទ</label>
            <div id="order__date__range" style="cursor: pointer;" class="form-control form-control-lg">
                <i class="fas fa-calendar text-muted"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down text-muted float-right"></i>
            </div>
            <?= $form->field($model, 'from_date')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'to_date')->hiddenInput()->label(false) ?>
        </div>
        <div class="col-lg-3">
            <label> កាលបរិច្ឆេទ</label>

            <?= $form->field($model, 'type_joined')->dropDownList([
                0 => 'ចូលអានសេរី',
                1 => 'ចូលអានតាមកាលវិភាគ'
            ], ['prompt' => 'Select Type', 'class' => 'form-control form-control-lg'])->label(false) ?>
        </div>

        <div class="col-lg-4">
            <div class="float-right">
                <div class="blank_space_label"></div>
                <?= Html::a(
                    ' <i class="bi bi-printer"></i> Report to PDF',
                    ['report/export-pdf-member-joined-library', 'MemberJoinedLibrarySearch[from_date]' => $fromDate, 'MemberJoinedLibrarySearch[to_date]' => $toDate, 'MemberJoinedLibrarySearch[type_joined]' => $typeJoined],
                    ['class' => 'btn btn-lg btn-danger btn-reportType']
                ) ?>

                <?= Html::a(
                    'Export to Excel test',
                    ['report/export-excel-member-joined-librarys', 'MemberJoinedLibrarySearch[from_date]' => $fromDate, 'MemberJoinedLibrarySearch[to_date]' => $toDate, 'MemberJoinedLibrarySearch[type_joined]' => $typeJoined],
                    ['class' => 'btn btn-lg btn-success']
                ) ?>

            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS

    var is_filter = $("#memberjoinedlibrarysearch-from_date").val() != '' ? true : false;

    if (!is_filter) {
        var start = moment().startOf('month'); // Default to start of the current month
        var end = moment().endOf('month'); // Default to end of the current month
    } else {
        var start = moment($("#memberjoinedlibrarysearch-from_date").val());
        var end = moment($("#memberjoinedlibrarysearch-to_date").val());
    }

    function cb(start, end) {
        $('#order__date__range span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        $("#memberjoinedlibrarysearch-from_date").val(start.format('YYYY-MM-DD'));
        $("#memberjoinedlibrarysearch-to_date").val(end.format('YYYY-MM-DD'));
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
        $('#formblogexperienceSearch').trigger('submit');
    });

    $(document).on("change", "#memberjoinedlibrarysearch-globalsearch", function() {
        $('#formblogexperienceSearch').trigger('submit');
    });


    $('#formblogexperienceSearch').on('change', function() {
        $(this).submit();
    });

JS;
$this->registerJs($script);
?>