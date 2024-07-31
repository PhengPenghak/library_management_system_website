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
        ['label' => 'អ្នកខ្ចីសៀវភៅ', 'url' => ['index']],
        ['label' => 'ខ្ចីសៀវភៅ'],
    ],
]);
echo '<hr class="pb-1 border-0">';

$base_url =  Yii::getAlias('@web');


$id = Yii::$app->request->get('id');

$socialItems = ArrayHelper::map(Book::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
?>
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
                if (empty($borrowBooks)) {
                ?>
                    <ul class="list-group" id="notfoundcontact">
                        <li class="list-group-item">រកមិនឃើញទិន្នន័យទេ!</li>
                    </ul>
                    <?php
                } else {
                    if (count($borrowBooks) > 0) {
                        foreach ($borrowBooks as $key => $value) {
                            $startDate = Yii::$app->formatter->asDate($value->start, 'yyyy-MM-dd');
                            $endDate = Yii::$app->formatter->asDate($value->end, 'yyyy-MM-dd');
                    ?>
                            <div class="tab-pane active show" id="<?= $key ?>">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row form-group" id="original-row">
                                            <div class="col-lg-11">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>សៀវភៅ</label>
                                                        <input type="text" class="form-control form-control-lg mb-3" id="tpye_social_media_<?= $key ?>" value="<?= $value->book->title ?>" disabled></input>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group field-borrowbook-code<?= $key ?> has-success">
                                                            <label>លេខសារពើភ័ណ្ខ</label>
                                                            <input type="text" id="borrowbook-code<?= $key ?>" class="form-control form-control-lg" value="<?= $value->code ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="form-group field-BookDistributionByGrade-quantity has-success">
                                                            <label for="model-start<?= $key ?>">ចំនួន</label>
                                                            <input type="number" id="BookDistributionByGrade-quantity<?= $key ?>" class="form-control form-control-lg quantity-input" value="<?= $value->quantity ?>" disabled>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-3">
                                                        <label for="dateRange<?= $key ?>">កាលបរិច្ឆេទ</label>
                                                        <input type="text" id="dateRange<?= $key ?>" value="<?= $startDate ?> - <?= $endDate ?>" name="dateRange" class="form-control form-control-lg dateRangePicker" disabled>
                                                        <input type="hidden" id="start<?= $key ?>" value="<?= $startDate ?>" name="BookDistributionByGrade[start][]">
                                                        <input type="hidden" id="end<?= $key ?>" value="<?= $endDate ?>" name="BookDistributionByGrade[end][]">
                                                    </div>


                                                    <div class="col-lg-2">
                                                        <div class="custom-control custom-checkbox mb-3">
                                                            <input type="checkbox" value="<?= $value->status ?>" disabled class="custom-control-input status-checkbox" id="status<?= $key ?>" <?= $value->status ? 'checked' : '' ?>>
                                                            <label class="custom-control-label" for="status<?= $key ?>">អនុញ្ញាត ខ្ចី​សៀវភៅ</label>
                                                            <input type="hidden" id="checkbox-value<?= $key ?>" value="<?= $value->status ?>">
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
                    }
                }
                ?>
            </div>
            <div class="row mt-3">

                <div class="col-lg-2">
                    <button type="button" class="btn btn-lg btn-block btn-success" id="add-form-btn">បង្កើតថ្មី</button>
                </div>
                <div class="col-lg-2">
                    <?= Html::submitButton('<i class="fas fa-save mr-2"></i>រក្សាទុក', ['class' => 'btn btn-lg btn-block btn-primary', 'id' => 'submitButton']) ?>
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

    var form = $('form#form_itinerary'),
    origForm = form.serialize();
    
    $('form#form_itinerary :input').on('change', function() {
        if(form.serialize() !== origForm){
          $("#submitButton").prop('disabled', false);
        }else{
          $("#submitButton").prop('disabled', true);
        }
    });

    $('#add-form-btn').click(function() {
        var rowCount = $('#tab-content .tab-pane').length;
        if (rowCount >= 3) {
            Swal.fire({
                title: 'ការព្រមាន!',
                text: 'អ្នកអាចបន្ថែមបានត្រឹមតែ 3 ជួរប៉ុណ្ណោះ។',
                icon: 'ការព្រមាន',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'យល់ព្រម'
            });
            return;
        }

        var key = new Date().valueOf();
        $("#notfoundcontact").hide();
        var options = '';
        $.each(socialItems, function(k, v) {
            options += `<option value="\${k}">\${v}</option>`;
        });

        $('#tab-content').append(
            `<div class="tab-pane active show" id="\${key}">
                <div class="card">
                    <div class="card-body">
                        <div class="row form-group" id="original-row">
                            <input type="text" hidden id="information_borrower_book_id\${key}" class="form-control form-control-lg" name="BorrowBook[information_borrower_book_id][]" autofocus="true" value="${id}" placeholder="" aria-invalid="false">
                            
                            <div class="col-lg-11">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>សៀវភៅ<abbr title="Required">*</abbr></label>
                                        <select type="text" name="BorrowBook[book_id][]" class="form-control form-control-lg mb-3" id="tpye_social_media_\${key}" required="">
                                        \${options}
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group field-borrowbook-code\${key} has-success">
                                            <label>លេខសារពើភ័ណ្ខ<abbr title="Required">*</abbr></label>
                                            <input type="text" id="borrowbook-code\${key}" class="form-control form-control-lg" name="BorrowBook[code][]" placeholder="បញ្ចូលលេខសារពើភ័ណ្ខ" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group field-borrowbook-quantity has-success">
                                            <label>ចំនួន<abbr title="Required">*</abbr></label>
                                            <input type="number" id="borrowbook-quantity\${key}" class="form-control form-control-lg quantity-input" name="BorrowBook[quantity][]" value="1" min="1" max="1" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="dateRange\${key}">កាលបរិច្ឆេទ<abbr title="Required">*</abbr></label>
                                        <input type="text" id="dateRange\${key}" name="dateRange" class="form-control form-control-lg">
                                        <input type="hidden" id="start\${key}" name="BorrowBook[start][]" required="">
                                        <input type="hidden" id="end\${key}" name="BorrowBook[end][]" required="">
                                    </div>
                                    <div class="col-lg-2">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" value="1" class="custom-control-input" id="status\${key}" checked>
                                                <label class="custom-control-label" for="status\${key}">អនុញ្ញាត ខ្ចី​សៀវភៅ​</label>
                                                <input type="hidden" id="checkbox-value\${key}" name="BorrowBook[status][]" value="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-1 align-self-center">
                                    <div class="d-flex align-items-center flex-column">
                                        <button type='button' class='btn bg-red text-light btn-icon btn-sm btn_remove mb-4' id='remove_row_\${key}' data-key="\${key}"><i class='fa fa-trash'></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                   
            </div>` 

        );
        $('form').on('submit', function(e) {
            var isValid = true;
            $('input[required]').each(function() {
                if ($(this).val() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $(this).siblings('.error-message').remove();
                    $(this).after('<div class="error-message" style="color: red;">This field is required</div>');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.error-message').remove();
                }
            });
            if (!isValid) {
                e.preventDefault();
            }
        });
        $(document).ready(function() {
            $('#dateRange' + key).daterangepicker({
                timePicker: false,
                locale: {
                    format: 'YYYY-MM-DD',
                }
            });

            $('#dateRange' + key).on('apply.daterangepicker', function(ev, picker) {
                $('#start' + key).val(picker.startDate.format('YYYY-MM-DD'));
                $('#end' + key).val(picker.endDate.format('YYYY-MM-DD'));
            });
        });

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

JS;
$this->registerJs($js);
?>