<?php

use app\models\Grade;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model->status = $model->isNewRecord ? 1 : $model->status;
?>

<div class="member-joined-library">
  <?php $form = ActiveForm::begin(); ?>
  <?= $form->field($model, 'status')->dropDownList(
    [1 => 'ចូលតាមកាលវិភាគ', 0 => 'ចូលសេរី'],
    ['class' => 'form-control form-control-lg', 'id' => 'status_type']
  )->label('ស្ថានភាព') ?>
  <?= $form->field($model, 'type_joined')->dropDownList(
    [1 => 'សិស្ស', 2 => 'គ្រូ', 3 => 'សមាគមន៍'],
    ['class' => 'form-control form-control-lg', 'id' => 'people_type']
  )->label('អ្នកអាន') ?>
  <?= $form->field($model, 'grade_id',)->widget(Select2::class, [
    'data' => ArrayHelper::map(Grade::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title'),
    'options' => ['placeholder' => 'ជ្រើសរើសថ្នាក់...', 'class' => 'custom-select'],
    'pluginOptions' => [
      'allowClear' => true,

    ],
  ])->label('ថ្នាក់'); ?>

  <?= $form->field($model, 'total_member')->textInput(['autofocus' => true, 'placeholder' => 'ចំនួនសរុប', 'class' => 'form-control-lg form-control'])->label("ចំនួនសរុប") ?>

  <?= $form->field($model, 'total_member_female')->textInput(['autofocus' => true, 'placeholder' => 'ចំនួនសិស្សស្រី់​​​', 'class' => 'form-control-lg form-control'])->label("ចំនួនសិស្សស្រី") ?>

  <div class="form-group field-model-end">
    <?= $form->field($model, 'dateTime')->textInput(['autofocus' => true, 'placeholder' => '', "id" => "model-date", 'class' => 'form-control-lg form-control'])->label("កាលបរិច្ឆេទ") ?>
  </div>
  <div class="my-3">
    <?= Html::submitButton('<i class="fas fa-save mr-2"></i>រក្សាទុក', ['class' => 'btn btn-lg  btn-primary px-5']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<<JS

  $('#model-date').daterangepicker({
    singleDatePicker: true,
    timePicker: true,
    startDate: moment().startOf('hour'),
    drops: 'up',
    opens:'center',
    locale: {
      format: 'YYYY-MM-DD hh:mm'
    },
  });
  $("#memberJoinLibrary").change(function(){
    if($(this).is(":checked")){
        $("#memberJoinLibrary-status").val(1);
    }else{
        $("#memberJoinLibrary-status").val(0);
    }
  });
$("#people_type").on("change", function(){
  if($(this).val() != 1){
    $(".custom-select").prop("disabled", true);
  }else{
    $(".custom-select").prop("disabled", false);
  }
});
  

JS;
$this->registerJs($script);
?>