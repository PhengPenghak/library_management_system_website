<?php

use app\assets\EditorAsset;
use app\models\Book;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\helpers\Url;

EditorAsset::register($this);

$this->title = 'Itinerary';
$this->params['breadcrumbs'][] = ['label' => 'អ្នកខ្ចីសៀវភៅ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


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
                if (empty($borrowBook)) {
                ?>
                    <ul class="list-group" id="notfoundcontact">
                        <li class="list-group-item">No data found!</li>
                    </ul>
                    <?php
                } else {
                    if (count($borrowBook) > 0) {
                        foreach ($borrowBook as $key => $value) {
                    ?>
                            <div class="tab-pane active show" id="<?= $key ?>">
                                <div class="row form-group" id="original-row">
                                    <div class="col-lg-4">
                                        <input type="text" hidden id="information_borrower_book_id<?= $key ?>" class="form-control form-control-lg" name="BorrowBook[information_borrower_book_id][]" autofocus="true" value="<?= $id ?>" placeholder="" aria-invalid="false">

                                        <?= Html::dropDownlist('BorrowBook[book_id][]', $value->book_id, $socialItems, ['class' => 'custom-select mb-3', 'id' => "book_id_{$key}", 'required' => true]) ?>
                                    </div>
                                    <div class="col-lg-4">
                                        <?= Html::textInput('BorrowBook[code][]', $value->code, ['class' => 'form-control mb-3', 'id' => "code_{$key}", 'required' => true]) ?>

                                    </div>
                                    <div class="col-lg-4">
                                        <?= Html::textInput('BorrowBook[quantity][]', $value->quantity, [
                                            'class' => 'form-control mb-3 quantity-input',
                                            'id' => "quantity_{$key}",
                                            'required' => true,
                                            'type' => 'number',
                                            'step' => 'any',
                                            'min' => 1,
                                            'max' => 1,
                                        ]) ?>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group field-model-end">
                                            <input type="datetime-local" id="model-end<?= $key ?>" class="form-control" value="<?= $value->start ?>" name="BorrowBook[start][]">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group field-model-end">
                                            <input type="datetime-local" id="model-end<?= $key ?>" class="form-control" value="<?= $value->end ?>" name="BorrowBook[end][]">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" value="<?= $value->status ?>" class="custom-control-input status-checkbox" id="status<?= $key ?>" <?= $value->status ? 'checked' : '' ?>>
                                            <label class="custom-control-label" for="status<?= $key ?>">Agree</label>
                                            <input type="hidden" id="checkbox-value<?= $key ?>" name="BorrowBook[status][]" value="<?= $value->status ?>">
                                            <div class="invalid-tooltip">Agree</div>
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
                    <?= Html::submitButton('<i class="fas fa-save mr-2"></i>Save', ['class' => 'btn btn-lg btn-block btn-primary']) ?>
                </div>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJsVar('socialItems', $socialItems);
$this->registerJsVar('id', $id);

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
                        <input type="text" hidden id="information_borrower_book_id\${key}" class="form-control form-control-lg" name="BorrowBook[information_borrower_book_id][]" autofocus="true" value="${id}" placeholder="" aria-invalid="false">

                        <div class="col-lg-4">
                            <select type="text" name="BorrowBook[book_id][]" class="form-control form-control-lg mb-3" id="tpye_social_media_\${key}">
                            \${options}
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group field-borrowbook-code\${key} has-success">
                                <input type="text" id="borrowbook-code\${key}" class="form-control form-control-lg" name="BorrowBook[code][]" placeholder="Enter your code">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group field-borrowbook-quantity has-success">
                                <input type="number" id="borrowbook-quantity\${key}" class="form-control form-control-lg quantity-input" name="BorrowBook[quantity][]" value="1">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group field-model-end">
                                <input type="datetime-local" id="model-start\${key}" class="form-control" name="BorrowBook[start][]">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group field-model-end">
                            
                                <input type="datetime-local" id="model-end\${key}" class="form-control" name="BorrowBook[end][]">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" value="1" class="custom-control-input" id="status\${key}" checked>
                                <label class="custom-control-label" for="status\${key}">Agree</label>
                                <input type="hidden" id="checkbox-value\${key}" name="BorrowBook[status][]" value="1">
                                <div class="invalid-tooltip">
                                    Agree
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

    // $(document).ready(function() {
    //     $('.quantity-input').each(function() {
    //         if ($(this).val() == 1) { 
    //             $(this).prop('disabled', true);
    //         }
    //     });

    //     $('.quantity-input').on('change', function() {
    //         if ($(this).val() == 1) {
    //             $(this).prop('disabled', true);
    //         } else {
    //             $(this).prop('disabled', false);
    //         }
    //     });
    // });

JS;
$this->registerJs($js);
?>