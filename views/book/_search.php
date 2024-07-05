<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DateRangePickerAsset;
use app\models\CategoryBook;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

DateRangePickerAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\blogSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .blank_space_label {
        padding-top: 32px;
    }
</style>
<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'options' => ['data-pjax' => true, 'id' => 'formblogexperienceSearch'],
        'method' => 'get',
    ]); ?>
    <div class="d-flex justify-content-end">
        <div class="mr-auto d-flex" style="gap: 10px;">
            <div>
                <?= $form->field($model, 'globalSearch')->textInput(['class' => 'form-control form-control-lg globalSearch', 'placeholder' => 'ស្វែងដោយរកចំណងជើង'])->label(false) ?>
            </div>
            <div class="form-group mr-auto" style="width: 200px;">
                <?= $form->field($model, 'categorySearch')->widget(Select2::class, [
                    'data' => ArrayHelper::map(CategoryBook::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title'),
                    'options' => ['placeholder' => 'ស្វែងដោយរកប្រភេទ', 'id' => 'searchByCategory', 'class' => 'custom-select', 'label' => false],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],

                ])->label(false); ?>
            </div>
            <div class="form-group mr-auto" style="width: 200px;">
                <?= $form->field($model, 'status')->widget(Select2::class, [
                    'data' => [0 => "មិនទំនេរ", 1 => "នៅទំនេរ"],
                    'options' => [
                        'placeholder' => 'ស្ថានភាពសៀវភៅ',
                        'id' => 'searchByStatus'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false); ?>
            </div>
        </div>



        <div class="ml-5">
            <!-- 
            <?= Html::a('Export to PDF', ['export-pdf'], ['class' => 'btn btn-danger btn-lg']) ?>

            <?= Html::a('Export to Excel', ['export-excel'], ['class' => 'btn btn-lg btn-warning']) ?> -->

            <?= Html::a('<i class="bi bi-plus-square mr-2"></i> បញ្ចូលសៀវភៅថ្មី', ['book/create'], ['class' => 'btn btn-lg btn-primary modalButton']) ?>
            <!-- <button type="button" data-title="Add Category Book" value="(['book/create'])" class="btn btn-lg btn-primary modalButton"><i class="bi bi-plus-square mr-2"></i>Add <span class="d-none d-lg-inline">Category Book</span></button> -->
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS
    $(document).on("change","#countrysearch-globalsearch", function(){
        $('#formblogexperienceSearch').trigger('submit');
    });
    $(".triggerModal").click(function(){
        $("#modal").modal("show")
            .find("#modalContent")
            .load($(this).attr("value"));
        $("#modal").find("#modal-label").text($(this).data("title"));
    });
    $("#searchByCategory, #searchByStatus").on("change",function(){
        pjaxClear();
    })
    function pjaxClear(){
        $("#formblogexperienceSearch").submit();
    }

JS;
$this->registerJs($script);
?>