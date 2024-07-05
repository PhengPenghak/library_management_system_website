<?php

use app\assets\EditorAsset;
use app\models\Book;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap4\Html;

EditorAsset::register($this);

$this->title = 'Itinerary';
$this->params['breadcrumbs'][] = ['label' => 'Itinerary List', 'url' => ['index']];
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
            <div class="tab-content">
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
                                            'class' => 'form-control mb-3',
                                            'id' => "quantity_{$key}",
                                            'required' => true,
                                            'type' => 'number',
                                            'step' => 'any',
                                            'min' => 1,
                                            'max' => 3,
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
                                            <input type="checkbox" value="<?= $value->status ?>" class="custom-control-input" id="checkbox-value<?= $key ?>">
                                            <label class="custom-control-label" for="status<?= $key ?>">Agree</label>
                                            <input type="hidden" id="checkbox-value<?= $key ?>" name="BorrowBook[status][]" value="<?= $value->status ?>">
                                            <div class=" invalid-tooltip">
                                                Agree
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
                <div id="form-container">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-lg btn-block btn-success" id="add-form-btn">Add New</button>
                </div>
                <div class="col-lg-3">
                    <?= Html::submitButton('<i class="fas fa-save mr-2"></i>Save', ['class' => 'btn btn-lg btn-block btn-primary ']) ?>
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

$(document).ready(function() {
    var rowLimit = 3; 
    var rowCount = 0;

    function canAddRow() {
        var quantities = [];
        $('input[name="BorrowBook[quantity][]"]').each(function() {
            quantities.push(parseInt($(this).val()));
        });

        if (quantities.length === 0) {
            return true;
        }

        if (quantities.length === 1) {
            return quantities[0] !== 3;
        }

        if (quantities.length === 2) {
            var first = quantities[0];
            var second = quantities[1];
            return (first + second !== 3 && first !== 3 && second !== 3);
        }

        if (quantities.length >= 3) {
            var first = quantities[0];
            var second = quantities[1];
            var third = quantities[2];
            return (first + second + third !== 3 && third === 1);
        }

        return true;
    }

    function validateQuantities() {
        var quantities = [];
        $('input[name="BorrowBook[quantity][]"]').each(function() {
            quantities.push(parseInt($(this).val()));
        });

        if (quantities.length >= 2) {
            var first = quantities[0];
            var second = quantities[1];
            if (first + second === 3) {
                $('input[name="BorrowBook[quantity][]"]').each(function() {
                    $(this).attr('min', 1);
                    $(this).attr('max', 1);
                });
                return; // Disable adding new rows if the sum of first and second quantities is 3
            } else {
                $('input[name="BorrowBook[quantity][]"]').each(function() {
                    $(this).attr('min', 1);
                    $(this).attr('max', 3);
                });
            }
        }

        if (quantities.length >= 3) {
            var first = quantities[0];
            var second = quantities[1];
            var third = quantities[2];
            if (first + second + third === 3) {
                $('input[name="BorrowBook[quantity][]"]').each(function() {
                    $(this).prop('disabled', true);
                });
                return; // Disable inputs if the sum of first, second, and third quantities is 3
            } else {
                $('input[name="BorrowBook[quantity][]"]').each(function() {
                    $(this).prop('disabled', false);
                });
            }
        } else {
            $('input[name="BorrowBook[quantity][]"]').each(function() {
                $(this).prop('disabled', false);
            });
        }
    }

    $('#add-form-btn').click(function() {
        if (!canAddRow()) {
            Swal.fire({
                icon: 'error',
                title: 'Cannot Add Row',
                text: 'The quantity constraints prevent adding a new row.',
            });
            return; // Prevent adding more rows if constraints are not met
        }

        var key = new Date().valueOf();
        $("#notfoundcontact").hide();
        var options = '';
        $.each(socialItems, function(k, v) {
            options += `<option value="\${k}">\${v}</option>`;
        });

        $('#form-container').append(
            `<div class="tab-pane active show" id="\${key}">
                <div id="form-container">
                    <div class="row form-group" id="original-row">
                        <input type="text" hidden id="information_borrower_book_id\${key}" class="form-control form-control-lg" name="BorrowBook[information_borrower_book_id][]" autofocus="true" value="${id}" placeholder="" aria-invalid="false">

                        <div class="col-lg-4">
                            <select type="text" name="BorrowBook[book_id][]" class="form-control form-control-lg mb-3" id="tpye_social_media_\${key}">
                            \${options}
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group field-borrowbook-code\${key} has-success">
                                <input type="text" id="borrowbook-code\${key}" class="form-control form-control-lg" name="BorrowBook[code][]" autofocus="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group field-borrowbook-quantity has-success">
                                <input type="number" id="borrowbook-quantity\${key}" class="form-control form-control-lg" name="BorrowBook[quantity][]" value="1" min="1" max="3" aria-invalid="false">
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
                                <input type="checkbox" value="0" class="custom-control-input" id="status\${key}">
                                <label class="custom-control-label" for="status\${key}">Agree</label>
                                <input type="hidden" id="checkbox-value\${key}" name="BorrowBook[status][]" value="0">
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
                </div>
            </div>`
        );

        rowCount++; // Increment the row counter

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
                    rowCount--; // Decrement the row counter when a row is removed
                    validateQuantities(); // Revalidate quantities after removing a row
                }
            });
        });

        $('input[name="BorrowBook[quantity][]"]').change(validateQuantities); // Add validation to quantity inputs
        validateQuantities(); // Initial validation
    });
});


JS;
$this->registerJs($js);
?>