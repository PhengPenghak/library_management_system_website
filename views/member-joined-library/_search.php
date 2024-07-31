<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DateRangePickerAsset;
use app\models\CategoryBook;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

DateRangePickerAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\blogSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .blank_space_label {
        padding-top: 32px;
    }
</style>
<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'options' => ['data-pjax' => true, 'id' => 'formblogexperienceSearch'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-4">
            <label> កាលបរិច្ឆេទ</label>
            <div id="order__date__range" style="cursor: pointer;" class="form-control form-control-lg">
                <i class="fas fa-calendar text-muted"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down text-muted float-right"></i>
            </div>
            <?= $form->field($model, 'from_date')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'to_date')->hiddenInput()->label(false) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => 'ស្វែងរកថ្នាក់អ្នកចូលអាន ...............', 'class' => 'form-control form-control-lg'])->label('ស្វែងរក') ?>
        </div>
        <div class="col-lg-2">
            <label>ស្ថានភាព</label>
            <?= $form->field($model, 'status')->widget(Select2::class, [
                'data' => [0 => "ចូលអានសេរី", 1 => "ចូលអានតាមកាលវិភាគ"],
                'options' => [
                    'placeholder' => 'ស្ថានភាពអ្នាកអានសៀវភៅ',
                    'id' => 'searchByStatus'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false); ?>
        </div>
        <div class="col-lg-4 ml-auto">
            <div class="float-right">
                <div class="blank_space_label"></div>
                <button type="button" data-title="បញ្ចូលអ្នកចូលអានសៀវភៅ" value="<?= Url::to(['form']) ?>" class="btn btn-lg btn-primary modalButton"><i class="bi bi-plus-square mr-2"></i>កត់ត្រាអ្នកអាន</span></button>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<<JS

    var is_filter = $("#memberjoinedlibrarysearch-from_date").val() != ''?true:false;

    if(!is_filter){
        var start = moment().startOf('week');
        var end = moment();
    }else{
        var start = moment($("#memberjoinedlibrarysearch-from_date").val());
        var end = moment($("#memberjoinedlibrarysearch-to_date").val());
    }

    function cb(start, end) {
        $('#order__date__range span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        $("#memberjoinedlibrarysearch-from_date").val(start.format('YYYY-MM-D'));
        $("#memberjoinedlibrarysearch-to_date").val(end.format('YYYY-MM-D'));
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
        $('#formblogexperienceSearch').trigger('submit');
    });

    $(document).on("change","#countrysearch-globalsearch", function(){
        $('#formblogexperienceSearch').trigger('submit');
    });

    $(document).on("change","#countrysearch-globalsearch", function(){
        $('#formblogexperienceSearch').trigger('submit');
    });

    $(".triggerModal").click(function(){
        $("#modal").modal("show")
            .find("#modalContent")
            .load($(this).attr("value"));
        $("#modal").find("#modal-label").text($(this).data("title"));
    });
    $("#searchByCategory, #searchByStatus").on("change",function(){
        pjaxClear();
    })
    function pjaxClear(){
        $("#formblogexperienceSearch").submit();
    }

JS;
$this->registerJs($script);
?>