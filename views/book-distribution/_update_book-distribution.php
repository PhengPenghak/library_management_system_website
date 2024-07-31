<?php

use app\assets\EditorAsset;
use app\models\Book;
use app\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;

EditorAsset::register($this);

$this->title = 'អ្នកខ្ចីសៀវភៅ';

echo Breadcrumbs::widget([
    'homeLink' => Yii::$app->params['breadcrumbs']['homeLink'],
    'links' => [
        ['label' => 'ព័ត៌មានទូទៅ', 'url' =>  Yii::$app->homeUrl],
        ['label' => 'ចែកសៀវភៅតាមថ្នាក់', 'url' => ['index']],
        ['label' => 'សងសៀវភៅ'],
    ],
]);

$base_url =  Yii::getAlias('@web');


$id = Yii::$app->request->get('id');

$socialItems = ArrayHelper::map(Book::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
?>
<hr class="border-0 pb-1">
<style>
    .select2-selection--multiple .select2-selection__rendered {
        max-height: unset !important;
        overflow: hidden !important;
        height: auto !important;
    }

    .select2-container .select2-selection--single {
        height: 2.75rem;
        font-size: 1rem;
    }
</style>


<div>
    <?php
    $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
        'id' => 'form_itinerary',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ]);
    ?>

    <div class=" card card-fluid">
        <div class="card-header">
            <?= $this->render('_header', ['modelHeader' => $modelHeader]) ?>
        </div>
        <div class="card-body">
            <div class="tab-content" id="tab-content">
                <?php
                if (empty($BookDistributionByGrades)) {
                ?>
                    <ul class="list-group" id="notfoundcontact">
                        <li class="list-group-item">No data found!</li>
                    </ul>
                    <?php
                } else {
                    if (count($BookDistributionByGrades) > 0) {
                        foreach ($BookDistributionByGrades as $key => $value) {
                    ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-pane active show" id="<?= $key ?>">
                                        <div class="row form-group" id="original-row">
                                            <div class="col-lg-11">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label for="model-start<?= $key ?>">សៀវភៅ</label>

                                                        <input type="text" hidden id="information_distribution_by_grade_id<?= $key ?>" class="form-control form-control-lg" name="BookDistributionByGrade[<?= $key ?>][information_distribution_by_grade_id]" value="<?= $id ?>" aria-invalid="false">
                                                        <?= Html::dropDownlist("BookDistributionByGrade[$key][book_id]", $value->book_id, $socialItems, ['class' => 'form-control form-control-lg custom-select mb-3', 'id' => "book_id_$key", 'required' => true]) ?>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label for="model-start<?= $key ?>">ចំនួន</label>

                                                        <?= Html::textInput("BookDistributionByGrade[$key][quantity]", $value->quantity, [
                                                            'class' => 'form-control form-control-lg mb-3 quantity-input',
                                                            'id' => "quantity_$key",
                                                            'required' => true,
                                                            'type' => 'number',
                                                            'step' => 'any',
                                                            'min' => 1,
                                                            'max' => 2000,
                                                        ]) ?>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <label for="dateRange<?= $key ?>">កាលបរិច្ឆេទ</label>
                                                        <input type="text" id="dateRange<?= $key ?>" value="<?= $value->start ?> - <?= $value->end ?>" name="dateRange" class="form-control form-control-lg dateRangePicker">
                                                        <input type="hidden" id="start<?= $key ?>" value="<?= $value->start ?>" name="BookDistributionByGrade[<?= $key ?>][start]">
                                                        <input type="hidden" id="end<?= $key ?>" value="<?= $value->end ?>" name="BookDistributionByGrade[<?= $key ?>][end]">
                                                    </div>


                                                    <div class="col-lg-3">
                                                        <div class="custom-control custom-checkbox mb-3">
                                                            <input type="checkbox" class="custom-control-input status-checkbox" id="status<?= $key ?>" <?= $value->status ? 'checked' : '' ?>>
                                                            <label class="custom-control-label" for="status<?= $key ?>">អនុញ្ញាត ខ្ចី​និងសងសៀវភៅ</label>
                                                            <input type="hidden" id="checkbox-value<?= $key ?>" name="BookDistributionByGrade[<?= $key ?>][status]" value="<?= $value->status ?>">
                                                            <div class="invalid-tooltip">អនុញ្ញាត ខ្ចី​និងសងសៀវភៅ</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                    } else {
                        ?>
                        <ul class="list-group" id="notfoundcontact">
                            <li class="list-group-item">Invalid data found!</li>
                        </ul>
                <?php
                    }
                }
                ?>
            </div>

            <div class="row mt-3">
                <div class="col-lg-2">
                    <?= Html::submitButton('<i class="fas fa-save mr-2"></i>រក្សាទុក', ['class' => 'btn btn-lg btn-block btn-primary']) ?>
                </div>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJsVar('socialItems', $socialItems);
$this->registerJsVar('id', $id);



$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js', ['position' => View::POS_HEAD]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js', ['position' => View::POS_HEAD]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);


$js = <<< JS
    $('#add-form-btn').click(function() {
    
        var key = new Date().valueOf();
        $("#notfoundcontact").hide();
        var options = '';
        $.each(socialItems, function(k, v) {
            options += `<option value="\${k}">\${v}</option>`;
        });

        $('#tab-content').append(
            `<div class="tab-pane active show" id="\${key}">
                    <div class="row form-group" id="original-row">
                        <input type="text" hidden id="information_distribution_by_grade_id\${key}" class="form-control form-control-lg" name="BookDistributionByGrades[information_distribution_by_grade_id][]" autofocus="true" value="${id}" placeholder="" aria-invalid="false">

                        <div class="col-lg-4">
                            <select type="text" name="BookDistributionByGrades[book_id][]" class="form-control form-control-lg mb-3" id="tpye_social_media_\${key}">
                            \${options}
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group field-BookDistributionByGrades-code\${key} has-success">
                                <input type="text" id="BookDistributionByGrades-code\${key}" class="form-control form-control-lg" name="BookDistributionByGrades[code][]" placeholder="Enter your code">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group field-BookDistributionByGrades-quantity has-success">
                                <input type="number" id="BookDistributionByGrades-quantity\${key}" class="form-control form-control-lg quantity-input" name="BookDistributionByGrades[quantity][]" value="1">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group field-model-end">
                                <input type="datetime-local" id="model-start\${key}" class="form-control" name="BookDistributionByGrades[start][]">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group field-model-end">
                            
                                <input type="datetime-local" id="model-end\${key}" class="form-control" name="BookDistributionByGrades[end][]">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" value="1" class="custom-control-input" id="status\${key}" checked>
                                <label class="custom-control-label" for="status\${key}">អនុញ្ញាត ខ្ចី​និងសងសៀវភៅ</label>
                                <input type="hidden" id="checkbox-value\${key}" name="BookDistributionByGrades[status][]" value="1">
                                <div class="invalid-tooltip">
                                    អនុញ្ញាត ខ្ចី​និងសងសៀវភៅ
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 align-self-center">
                          <div class="d-flex align-items-center flex-column">
                            <button type='button' class='btn bg-red text-light btn-icon btn-sm btn_remove' id='remove_row_\${key}' data-key="\${key}"><i class='fa fa-trash'></i></button>
                          </div>
                        </div>
                    </div>
                
            </div>`
        );

        

        $('#status' + key).change(function() {
            if ($(this).is(':checked')) {
                $('#checkbox-value' + key).val(1);
            } else {
                $('#checkbox-value' + key).val(0);
            }
        });


        $(document).on("click", ".btn_remove", function() {
            var key = $(this).data("key");
            Swal.fire({
                title: "Warning!",
                text: "Are you sure, you want to delete this element?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Delete it.'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(".tab-pane[id='" + key + "']").remove();
                   
                }
            });
        });

       
    });

    $(document).ready(function() {
        $('.status-checkbox').each(function() {
            var key = $(this).attr('id').replace('status', '');
            var hiddenInput = $('#checkbox-value' + key);

            if ($(this).is(':checked')) {
                hiddenInput.val(1);
            } else {
                hiddenInput.val(0);
            }

            $(this).change(function() {
                if ($(this).is(':checked')) {
                    hiddenInput.val(1);
                } else {
                    hiddenInput.val(0);
                }
            });
        });
    });

    $(document).ready(function() {
        $('.dateRangePicker').each(function() {
            var key = $(this).attr('id').replace('dateRange', '');
            var start = $('#start' + key).val();
            var end = $('#end' + key).val();

            $(this).daterangepicker({
                timePicker: false,
                locale: {
                    format: 'YYYY-MM-DD',
                },
                startDate: start,
                endDate: end
            });

            $(this).on('apply.daterangepicker', function(ev, picker) {
                $('#start' + key).val(picker.startDate.format('YYYY-MM-DD'));
                $('#end' + key).val(picker.endDate.format('YYYY-MM-DD'));
            });
        });
    });


    $(document).ready(function() {
        $('.dateRangePicker').each(function() {
            var key = $(this).attr('id').replace('dateRange', '');
            var start = $('#start' + key).val();
            var end = $('#end' + key).val();

            $(this).daterangepicker({
                timePicker: false,
                locale: {
                    format: 'YYYY-MM-DD',
                },
                startDate: start,
                endDate: end
            });

            $(this).on('apply.daterangepicker', function(ev, picker) {
                $('#start' + key).val(picker.startDate.format('YYYY-MM-DD'));
                $('#end' + key).val(picker.endDate.format('YYYY-MM-DD'));
            });
        });
    });

JS;
$this->registerJs($js);
?>