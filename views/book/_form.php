<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\EditorAsset;
use app\models\CategoryBook;
use app\models\LocationBook;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\assets\DateRangePickerAsset;


DateRangePickerAsset::register($this);
EditorAsset::register($this);
?>
<style>
    textarea {
        resize: none;
    }

    .form-group.note-form-group.note-group-select-from-files {
        display: none;
    }

    .img-thumbnail-banner {
        width: 200px !important;
        height: 200px !important;
        object-fit: cover;
    }
</style>
<div class="blog-form pt-5">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'bookForm',
            'enctype' => 'multipart/form-data'
        ],
    ]); ?>

    <div class="card card-bg-default">
        <div class="card-body text-dark">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-upload-image">
                        <div class="preview">
                            <?= Html::img($model->isNewRecord ? Yii::getAlias("@web/img/not_found_sq.png") : $model->getThumb(), ['class' => 'img-thumbnail-banner', 'id' => 'image_book_upload-preview', 'onerror' => "this.onerror=null;this.src='" . Yii::getAlias('@web/img/not_found_sq.png') . "';"]) ?>
                        </div>
                        <label for="image_book_upload"><i class="fas fa-plus"></i> ជ្រើសរើសរូបភាព</label>
                        <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*', 'id' => 'image_book_upload'])->label(false) ?>
                    </div>

                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4">
                            <?= $form->field($model, 'title')->textInput(['class' => 'form-control form-control-lg', 'autofocus' => true, 'placeholder' => 'បញ្ចូលចំណងជើងរឿង'])->label() ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'category_book_id')->widget(Select2::class, [
                                'data' => ArrayHelper::map(CategoryBook::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title'),
                                'options' => ['placeholder' => 'ជ្រើសរើសប្រភេទសៀវភៅ', 'class' => 'custom-select'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'quantity')->input('number', [
                                'min' => 1,
                                'class' => 'form-control form-control-lg limitNumber'
                            ])->label('ចំនួនសៀវភៅ') ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'publishing')->textInput(['class' => 'form-control form-control-lg', 'autofocus' => true, 'placeholder' => 'គ្រឹះស្ថានបោះពុម្ភផ្សាយ'])->label('គ្រឹះស្ថានបោះពុម្ភផ្សាយ') ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'author')->textInput(['class' => 'form-control form-control-lg', 'autofocus' => true, 'placeholder' => 'បញ្ចូលឈ្មោះអ្នកនិពន្ធ'])->label() ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'location_id',)->widget(Select2::class, [
                                'data' => ArrayHelper::map(LocationBook::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title'),
                                'options' => ['placeholder' => 'ជ្រើសរើសទីតាំងដាក់សៀវភៅ', 'class' => 'custom-select'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'sponse')->textInput(['class' => 'form-control form-control-lg', 'autofocus' => true, 'placeholder' => 'បញ្ចូលប្រភពសៀវភៅ'])->label() ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'publishing')->textInput([
                                'id' => 'model-date',
                                'class' => 'form-control form-control-lg',
                                'placeholder' => 'បញ្ខូលឆ្នាំបោះពុម្ភ'
                            ])->label('ឆ្នាំបោះពុម្ភ') ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'class' => 'form-control form-control-lg'])->label('កូដសៀវភៅ') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <span class="font-weight-bold">ស្ថានភាព</span>
                                        <?= $form->field($model, 'status')->hiddenInput(['value' => !empty($model->status) ? $model->status : 0])->label(false); ?>
                                        <label class="switcher-control switcher-control-danger switcher-control-lg">
                                            <input type="checkbox" value="<?= $model->status ?>" id="book"
                                                class="switcher-input" <?= $model->status == 1 ? 'checked' : '' ?>>
                                            <span class="switcher-indicator"></span>
                                            <span class="switcher-label-on"><i class="fas fa-check"></i></span>
                                            <span class="switcher-label-off"><i class="fas fa-times"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-end">
                        <div class="col-lg-3">
                            <?= Html::submitButton('<i class="fas fa-save mr-2"></i>រក្សាទុក', ['class' => 'btn btn-lg btn-block btn-primary']) ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<<JS
    $(".submit-button").click(function(){
        var type = $(this).data("type");
        $("input[name='submit_type']").val(type);
        $('#bookForm').trigger('submit');
    });

    $("#book").change(function(){
        if($(this).is(":checked")){
            $("#book-status").val(1);
        }else{
            $("#book-status").val(0);
        }
    });

    $("#image_book_upload").change(function(){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("image_book_upload-preview");
            preview.src = src;
            
        }
    });
    $(".limitNumber").on("change", function(){
        var value = $(this).val();
        if (value < 1 || value.startsWith('0')) {
            $(this).val(1);
        }
    })
    $(document).ready(function() {
        $('#model-date').daterangepicker({
            singleDatePicker: true,  
            timePicker: false,
            startDate: moment().startOf('day'),
            drops: 'up',    
            opens: 'center', 
            locale: {
                format: 'YYYY-MM-DD', 
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
                customRangeLabel: 'Custom Range'
            },
            showDropdowns: true, 
            minYear: 2000,         
            maxYear: 2100 
        });
    });
JS;

$this->registerJs($script);

?>