<?php

use app\assets\JqueryMonthPicher;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

// JqueryMonthPicher::register($this);
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

    <?= $this->render('_search', ['model' => $searchModel, 'scheduleType' => $scheduleType, 'reportType' => $reportType, 'selectedDate' => $selectedDate]);
    ?>

    <hr class="border-0">

    <div class="card card-bg-default">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
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
        // console.log(val);
        
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
    
JS;
$this->registerJs($script);
?>