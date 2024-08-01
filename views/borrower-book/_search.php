<?php

use app\assets\DateRangePickerAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


DateRangePickerAsset::register($this);

?>

<style>
    .blank_space_label {
        padding-top: 32px;
    }
</style>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'options' => ['data-pjax' => true, 'id' => 'formblogSearch'],
    'method' => 'get',
]); ?>


<div class="row">
    <div class="col-lg-4">
        <label>កាលបរិច្ឆេទ</label>
        <div id="order__date__range" style="cursor: pointer;" class="form-control form-control-lg">
            <i class="fas fa-calendar text-muted"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down text-muted float-right"></i>
        </div>
        <?= $form->field($model, 'from_date')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'to_date')->hiddenInput()->label(false) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => 'ស្វែងរកឈ្មោះខ្ចីសៀវភៅ ...............', 'class' => 'form-control form-control-lg'])->label('ស្វែងរក') ?>
    </div>
    <div class="col-lg-4">
        <div class="float-right">
            <div class="blank_space_label"></div>
            <a data-title="Add Borrow Book" href="<?= Url::to(['create-information-borrower-book']) ?>" class="btn btn-lg btn-primary"><i class="bi bi-plus-square mr-2"></i>បង្កើត​<span class="d-none d-lg-inline">អ្នកខ្ចីសៀវភៅ</span></a>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>

<?php
$script = <<<JS

    var is_filter = $("#infomationborrowerbooksearch-from_date").val() != ''?true:false;

    if(!is_filter){
        var start = moment().startOf('week');
        var end = moment();
    }else{
        var start = moment($("#infomationborrowerbooksearch-from_date").val());
        var end = moment($("#infomationborrowerbooksearch-to_date").val());
    }

    function cb(start, end) {
        $('#order__date__range span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        $("#infomationborrowerbooksearch-from_date").val(start.format('YYYY-MM-D'));
        $("#infomationborrowerbooksearch-to_date").val(end.format('YYYY-MM-D'));
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
        $('#formblogSearch').trigger('submit');
    });

    $(document).on("change","#infomationborrowerbooksearch-globalsearch", function(){
        $('#formblogSearch').trigger('submit');
    });


    $(".triggerModal").click(function(){
        $("#modal").modal("show")
            .find("#modalContent")
            .load($(this).attr("value"));
        $("#modal").find("#modal-label").text($(this).data("title"));

    });

JS;
$this->registerJs($script);
?>