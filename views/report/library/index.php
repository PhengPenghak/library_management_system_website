<?php

use app\assets\JqueryMonthPicher;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

JqueryMonthPicher::register($this);
$this->title = 'របាយការណ៍អានសៀវភៅ';
$this->params['breadcrumbs'][] = $this->title;
$scheduleType = Yii::$app->request->getQueryParam('scheduleType', 0);
$reportType = Yii::$app->request->getQueryParam('reportType', 0);
?>
<style>
    #MonthPicker_Button_IconDemo {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        opacity: 0;
    }

    .flatpickr-day {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<div>

    <?php // $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?php Pjax::begin(['id' => 'pjaxActivity']); ?>

    <?php
    $form = ActiveForm::begin([
        'action' => ['report/library'],
        'method' => 'get',
        'options' => ['data-pjax' => false, 'id' => 'formActivitySearch'],
    ]);
    ?>
    <div class="d-flex">
        <div class="d-flex">

            <div class="position-relative" style="width: 200px;">
                <!-- <input id="IconDemo" name="selectedDate" value="<?= $selectedDate ?>" class='Default selectedDate form-control form-control-lg' placeholder="Select date" readonly type="text" /> -->
                <input type="text" name="selectedDate" value="<?= $selectedDate ?>" id="selectedDate" class="form-control form-control-lg" readonly />
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
                            'placeholder' => 'ស្ថានភាព',
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


                    <?= Select2::widget([
                        'name' => 'scheduleType',
                        'data' => [
                            0 => "ចូលសេរី",
                            1 => "ចូលតាមកាលវិភាគ"
                        ],
                        'value' => $scheduleType,
                        'options' => [
                            'placeholder' => 'ស្ថានភាព',
                            'id' => 'scheduleType',
                            'class' => 'scheduleType',
                            'style' => 'width:300px'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="ml-auto">
            <!-- <button class="btn btn-lg btn-success">
                Search <i class="bi bi-search"></i>
            </button> -->
            <?= Html::a(' <i class="bi bi-printer"></i> Report to PDF', ['report/report-library', 'selectMonth' => $selectedDate, 'scheduleType' => $scheduleType, 'reportType' => $reportType], ['class' => 'btn btn-lg btn-danger']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    <hr class="border-0">

    <div class="card card-bg-default">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $activityProvider,
                'tableOptions' => [
                    'class' => 'table table-hover',
                    'cellspacing' => '0',
                    'width' => '100%',
                ],
                'layout' => "
            <div class='table-responsive'>
                {items}
            </div>
            <hr>
            <div class='row'>
                <div class='col-md-6'>
                    {summary}
                </div>
                <div class='col-md-6'>
                    {pager}
                </div>
            </div>
        ",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'grade_id',
                        'label' => 'ថ្នាក់',
                        'value' => function ($model) {
                            return $model->grade ? $model->grade->title : 'មិនមែនសិស្ស';
                        },
                    ],
                    [
                        'attribute' => 'type_joined',
                        'label' => 'អ្នកចូលអាន',
                        'value' => function ($model) {
                            return $model->getJionType();
                        }
                    ],
                    [
                        'attribute' => 'total_member',
                        'label' => 'សិស្សសរុប',
                    ],
                    [
                        'attribute' => 'total_member_female',
                        'label' => 'សិស្សស្រីសរុប',
                    ],
                    [
                        'attribute' => 'created_by',
                        'label' => 'បង្កើត​ឡើង​ដោយ',
                        'value' => function ($model) {
                            return $model->createdBy ? $model->createdBy->username : 'N/A';
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'កាលបរិច្ឆេទបង្កើត',
                        'value' => function ($model) {
                            return Yii::$app->formater->maskDateKH($model->dateTime);
                        }
                    ],
                    [
                        'attribute' => 'ស្ថានភាព',
                        'headerOptions' => ['class' => 'text-primary'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->getStatusTemp();
                        }
                    ],
                    // [
                    //     'class' => ActionColumn::class,
                    //     'header' => 'កែប្រែ',
                    //     'headerOptions' => ['class' => 'text-center text-primary'],
                    //     'contentOptions' => ['class' => 'text-center'],
                    //     'template' => '{update} {delete}',
                    //     'buttons' => [
                    //         'update' => function ($url, $model) {
                    //             return Html::button('<i class="fas fa-pen"></i>', ['data-title' => 'កែប្រែអ្នកចូលអានសៀវភៅ', 'value' => Url::toRoute(['/member-joined-library/form', 'id' => $model->id]), 'class' => 'btn btn-sm btn-icon btn-secondary modalButton']);
                    //         },
                    //         'delete' => function ($url, $model) {
                    //             return Html::button('<i class="bi bi-trash2"></i>', [
                    //                 'class' => 'btn btn-sm btn-icon btn-secondary button-delete',
                    //                 'title' => 'លុបទីតាំងដាក់សៀវភៅ',
                    //                 'method' => 'post',
                    //                 'data' => [
                    //                     'confirm' => 'តើអ្នកប្រាដកទេ?',
                    //                     'value' => Url::to(['delete', 'id' => $model->id]),
                    //                     'toggle' => 'tooltip',
                    //                 ]
                    //             ]);
                    //         }
                    //     ],
                    // ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<?php
echo $this->render('//site/modal_scrollable');
$script = <<<JS
$(".month-picker-open-button").addClass("ui-state-active");



  $(document).on("click", ".modalButton", function() {
    $("#modalScrollable").modal("show")
      .find("#modalContent")
      .load($(this).attr("value"));
    $("#modalScrollable").find("#modalScrollableLabel").text($(this).data("title"));
  });

  $('#modalScrollable').on('hidden.bs.modal', function(e) {
    $("#modalContent").html("");
  });

  yii.confirm = function (message, okCallback, cancelCallback) {
        var val = $(this).data('value');
        console.log(val);
        
        if($(this).hasClass('button-delete')){
            Swal.fire({
                title: "ការព្រមាន!",
                text: "តើអ្នកចង់លុបសៀវភៅនេះឬ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'យល់ព្រម',
                cancelButtonText: 'បោះបង់'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(val);
                }
            });
        }

    };
    $(document).on('pjax:success', function() {
        pjaxInit();
    });
    pjaxInit();
    function pjaxInit(){
         flatpickr("#selectedDate", {
             altInput: true,
             altFormat: "F j, Y",
             dateFormat: "Y-m-d",
            maxDate: 'today',
             onChange: function(selectedDates, dateStr, instance) {
                pjaxClear();
             }
         });    
        $(".scheduleType").on("change",function(){
            $('#formActivitySearch').trigger('submit');
        })
    }
     $(".scheduleType").on("change",function(){
         pjaxClear();
     })
     $(".reportType").on("change",function(){
         pjaxClear();
     })
     
    function pjaxClear(){
        $("#formActivitySearch").submit();
    }
    
JS;
$this->registerJs($script);
?>