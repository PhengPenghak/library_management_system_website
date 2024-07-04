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
                                        <?= Html::dropDownlist('book_id[]', $value['book_id'], $socialItems, ['class' => 'custom-select mb-3', 'id' => "book_id_{$key}", 'required' => true]) ?>
                                    </div>
                                    <div class="col-lg-4">
                                        <?= Html::textInput('code[]', $value['code'], ['class' => 'form-control mb-3', 'id' => "code_{$key}", 'required' => true]) ?>

                                    </div>
                                    <div class="col-lg-4">
                                        <?= Html::textInput('quantity[]', $value['quantity'], [
                                            'class' => 'form-control mb-3',
                                            'id' => "quantity_{$key}",
                                            'required' => true,
                                            'type' => 'number',
                                            'step' => 'any',
                                            'min' => 0,
                                            'max' => 3,
                                        ]) ?>
                                    </div>


                                    <div class="col-lg-4">
                                        <div class="form-group field-model-end">
                                            <input type="datetime-local" id="model-end<?= $key ?>" class="form-control" value="<?= $value['start'] ?>" name="BorrowBook[start][]">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group field-model-end">
                                            <input type="datetime-local" id="model-end<?= $key ?>" class="form-control" value="<?= $value['end'] ?>" name="BorrowBook[end][]">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="list-group-item d-flex justify-content-between align-items-center px-1"> Switch me!
                                            <label class="switcher-control switcher-control-success">
                                                <input type="checkbox" name="onoffswitch" class="switcher-input" checked="">
                                                <span class="switcher-indicator"></span>
                                            </label>
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

var rowCount = 0;
$('#add-form-btn').click(function() {
    rowCount++;
    if (rowCount >= 4) {
        $('#add-form-btn').prop('disabled', true).text('Maximum rows reached');
        Swal.fire({
            icon: 'warning',
            title: 'Sweet Alert!',
            text: 'Maximum rows reached',
            confirmButtonText: 'OK'
        });

        $('input[id^="borrowbook-quantity"]').prop('disabled', true);
        return;
    }

    

    var exceededMaxQuantity = false;
    $('.row.form-group').each(function() {
        var quantity1 = parseInt($(this).find('input[name="BorrowBook[quantity][]"]').eq(0).val());
        var quantity2 = parseInt($(this).find('input[name="BorrowBook[quantity][]"]').eq(1).val());
        var quantity3 = parseInt($(this).find('input[name="BorrowBook[quantity][]"]').eq(2).val());

        if ((quantity1 === 3) || (quantity1 + quantity2 === 3) || (quantity1 + quantity2 + quantity3 === 3)) {
            exceededMaxQuantity = true;
            return false; 
        }
    });

    if (exceededMaxQuantity) {
        $('#add-form-btn').prop('disabled', true).text('Maximum rows reached');
        Swal.fire({
            icon: 'warning',
            title: 'Sweet Alert!',
            text: 'Maximum rows reached based on quantity conditions',
            confirmButtonText: 'OK'
        });
        return;
    }

    $('input[id^="borrowbook-quantity"]').on('input', function() {
        if (rowCount >= 4) {
            $(this).val($(this).data('oldValue')); // Revert to old value if row count >= 4
        } else {
            $(this).data('oldValue', $(this).val()); // Store current value as old value
        }
        return;
    });


    var key = new Date().valueOf();
    $("#notfoundcontact").hide();
    var options = '';
    $.each(socialItems,function(k,v){
      options += `<option value="\${k}">\${v}</option>`;
    });

    $('#form-container').append(
        `<div class="tab-pane active show" id="\${key}">
            <div id="form-container">
                <div class="row form-group" id="original-row">
                    <input type="text" hidden id="information_borrower_book_id\${key}" class="form-control form-control-lg" name="BorrowBook[information_borrower_book_id][]" autofocus="true" value="\${id}" placeholder="" aria-invalid="false">

                    <div class="col-lg-4">
                        <select type="text" name="BorrowBook[book_id][]" class="form-control form-control-lg mb-3" id="tpye_social_media_\${key}" />
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
                            <input type="number" id="borrowbook-quantity\${key}" class="form-control form-control-lg" name="BorrowBook[quantity][]" value="1" min="1" max="3" step="1" aria-invalid="false">
                        </div>                            
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group field-model-end">
                            <input type="datetime-local" id="model-end\${key}" class="form-control" name="BorrowBook[start][]">
                        </div>                           
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group field-model-end">
                            <input type="datetime-local" id="model-end\${key}" class="form-control" name="BorrowBook[end][]">
                        </div>                          
                    </div>
                 
                </div>
            </div>
        </div>`
    ); 
});

JS;
$this->registerJs($js);
?>