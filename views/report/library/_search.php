<?php

use app\assets\DateRangePickerAsset;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BorrowBookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="borrow-book-search">

    <?php
    $form = ActiveForm::begin([
        'action' => ['report/library'],
        'method' => 'get',
        'options' => ['data-pjax' => true, 'id' => 'formActivitySearch'],
    ]);
    ?>
    <div class="d-flex">
        <div class="d-flex">

            <div class="position-relative" style="width: 200px;">
                <?= $form->field($model, 'selectedDate')->textInput(['class' => 'form-control form-control-lg ', 'placeholder' => 'ស្វែងរកថ្នាក់...', 'id' => 'selectedDate'])->label(false) ?>

            </div>
            <div>
                <div class="ml-3" style="width: 200px;">

                    <?= Select2::widget([
                        'name' => 'reportType',
                        'data' => [
                            0 => "របាយការណ៍ប្រចាំខែ",
                            1 => "របាយការណ៍ប្រចាំឆ្នាំ"
                        ],
                        'value' => $reportType,
                        'options' => [
                            'placeholder' => 'ប្រភេទរបាយការណ៍',
                            'id' => 'reportType',
                            'class' => 'reportType',
                            'style' => 'width:300px'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>

                </div>
            </div>
            <div>
                <div class="ml-3" style="width: 200px;">
                    <?= $form->field($model, 'scheduleType')->widget(Select2::class, [
                        'data' => [
                            0 => "ចូលសេរី",
                            1 => "ចូលតាមកាលវិភាគ"
                        ],
                        'options' => [
                            'placeholder' => 'ស្ថានភាព',
                            'id' => 'scheduleType',
                            'class' => 'scheduleType',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="ml-auto">
            <?php
            $selectedDate = Yii::$app->request->get('MemberJoinedLibrarySearch')['selectedDate'] ?? date('Y-m');
            $scheduleType = Yii::$app->request->get('MemberJoinedLibrarySearch')['scheduleType'] ?? 0;
            $reportType = Yii::$app->request->get('reportType') ?? 0;
            ?>
            <?= Html::a(' <i class="bi bi-printer"></i> Report to PDF', ['report/report-library', 'selectedDate' => $selectedDate, 'scheduleType' => $scheduleType, 'reportType' => $reportType], ['class' => 'btn btn-lg btn-danger btn-reportType']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<<JS
    pjaxInit();
    function pjaxInit(){
         flatpickr("#selectedDate", {
             altInput: true,
             altFormat: "F j, Y",
             dateFormat: "Y-m-d",
            maxDate: 'today',
         });    
    }
    $(document).on("change","#countrysearch-globalsearch", function(){
        $('#formblogexperienceSearch').trigger('submit');
    });
    $(".triggerModal").click(function(){
        $("#modal").modal("show")
            .find("#modalContent")
            .load($(this).attr("value"));
        $("#modal").find("#modal-label").text($(this).data("title"));
    });
    $("#selectedDate, #scheduleType, #reportType").on("change",function(){
        pjaxClear();
    })
    function pjaxClear(){
        $("#formActivitySearch").submit();
    }

JS;
$this->registerJs($script);
?>