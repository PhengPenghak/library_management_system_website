<?php

use app\assets\EditorAsset;
use app\models\Book;
use app\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Html;
use yii\web\View;

EditorAsset::register($this);

$this->title = 'អ្នកទទួលសៀវភៅ';
echo Breadcrumbs::widget([
    'homeLink' => Yii::$app->params['breadcrumbs']['homeLink'],
    'links' => [
        ['label' => 'ព័ត៌មានទូទៅ', 'url' =>  Yii::$app->homeUrl],
        ['label' => 'ចែកសៀវភៅតាមថ្នាក់', 'url' => ['index']],
        ['label' => 'អ្នកទទួលសៀវភៅ'],
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
                            <div class="tab-pane active show" id="<?= $key ?>">
                                <div class="row form-group" id="original-row">
                                    <div class="col-lg-11">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label>សៀវភៅ</label>
                                                <input type="text" class="form-control form-control-lg mb-3" id="tpye_social_media_<?= $key ?>" value="<?= $value->book->title ?>" disabled></input>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group field-BookDistributionByGrade-quantity has-success">
                                                    <label for="model-start<?= $key ?>">ចំនួន</label>
                                                    <input type="number" id="BookDistributionByGrade-quantity<?= $key ?>" class="form-control form-control-lg quantity-input" value="<?= $value->quantity ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <label for="dateRange<?= $key ?>">កាលបរិច្ឆេទ</label>
                                                <input type="text" id="dateRange<?= $key ?>" value="<?= $value->start ?> - <?= $value->end ?>" name="dateRange" class="form-control form-control-lg dateRangePicker" disabled>
                                                <input type="hidden" id="start<?= $key ?>" value="<?= $value->start ?>" name="BookDistributionByGrade[start][]">
                                                <input type="hidden" id="end<?= $key ?>" value="<?= $value->end ?>" name="BookDistributionByGrade[end][]">
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" value="<?= $value->status ?>" disabled class="custom-control-input status-checkbox" id="status<?= $key ?>" <?= $value->status ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="status<?= $key ?>">អនុញ្ញាត ខ្ចី​និងសងសៀវភៅ</label>
                                                    <input type="hidden" id="checkbox-value<?= $key ?>" value="<?= $value->status ?>">
                                                    <div class="invalid-tooltip">អនុញ្ញាត ខ្ចី​និងសងសៀវភៅ</div>
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
                    <button type="button" class="btn btn-lg btn-block btn-success" id="add-form-btn"><i class="fas fa-plus"></i> ​បង្កើតថ្មី</button>
                </div>
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
                        <input type="text" hidden id="information_distribution_by_grade_id\${key}" class="form-control form-control-lg" name="BookDistributionByGrade[information_distribution_by_grade_id][]" autofocus="true" value="${id}" placeholder="" aria-invalid="false">
                        <div class="col-lg-11">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>សៀវភៅ</label>
                                    <select type="text" name="BookDistributionByGrade[book_id][]" class="form-control form-control-lg mb-3" id="tpye_social_media_\${key}" required>
                                    \${options}
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group field-BookDistributionByGrade-quantity has-success">
                                        <label>ចំនួន</label>
                                        <input type="number" id="BookDistributionByGrade-quantity\${key}" class="form-control form-control-lg quantity-input" name="BookDistributionByGrade[quantity][]" value="1">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="dateRange\${key}">កាលបរិច្ឆេទ</label>
                                    <input type="text" id="dateRange\${key}" name="dateRange" class="form-control form-control-lg">
                                    <input type="hidden" id="start\${key}" name="BookDistributionByGrade[start][]">
                                    <input type="hidden" id="end\${key}" name="BookDistributionByGrade[end][]">
                                </div>
                                <div class="col-lg-2">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" value="1" class="custom-control-input" id="status\${key}" checked>
                                        <label class="custom-control-label" for="status\${key}">អនុញ្ញាត ខ្ចី​និងសងសៀវភៅ</label>
                                        <input type="hidden" id="checkbox-value\${key}" name="BookDistributionByGrade[status][]" value="1">
                                        <div class="invalid-tooltip">
                                            អនុញ្ញាត ខ្ចី​និងសងសៀវភៅ
                                        </div>
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
            </div>`
        );

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