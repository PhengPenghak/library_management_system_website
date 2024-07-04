<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DateRangePickerAsset;
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
        <div>
            <?= $form->field($model, 'globalSearch')->textInput(['class' => 'form-control form-control-lg globalSearch', 'placeholder' => 'Search…'])->label(false) ?>
        </div>

        <div class="ml-5">

            <?= Html::a('Export to PDF', ['export-pdf'], ['class' => 'btn btn-danger btn-lg']) ?>

            <?= Html::a('Export to Excel', ['export-excel'], ['class' => 'btn btn-lg btn-warning']) ?>

            <button type="button" data-title="Add Category Book" value="<?= Url::to(['create']) ?>" class="btn btn-lg btn-primary modalButton"><i class="bi bi-plus-square mr-2"></i>Add <span class="d-none d-lg-inline">Category Book</span></button>
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

JS;
$this->registerJs($script);
?>