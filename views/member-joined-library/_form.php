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

  <?= $form->field($model, 'total_member')->textInput(['autofocus' => true, 'placeholder' => 'ចំនួនសរុប', 'class' => 'form-control-lg form-control'])->label(false) ?>

  <?= $form->field($model, 'total_member_female')->textInput(['autofocus' => true, 'placeholder' => 'ចំនួនសិស្សស្រី់​​​', 'class' => 'form-control-lg form-control'])->label(false) ?>

  <div class="form-group field-model-end">
    <?= $form->field($model, 'dateTime')->textInput(['autofocus' => true, 'placeholder' => 'ចំនួនសរុប', "type" => "datetime-local", "id" => "model-end", 'class' => 'form-control-lg form-control'])->label(false) ?>
  </div>


  <div class="card border">
    <div class="card-body">
      <div class="card-title"><?= Yii::t('app', 'ស្ថានភាព') ?></div>

      <div class="">
        <?= $form->field($model, 'status')->hiddenInput(['id' => 'memberJoinLibrary-status'])->label(false); ?>
        <label class="switcher-control switcher-control-success switcher-control-lg">
          <input type="checkbox" value="<?= $model->status ?>" id="memberJoinLibrary" class="switcher-input" <?= $model->status == 1 ? 'checked' : '' ?>>
          <span class="switcher-indicator"></span>
          <span class="switcher-label-on"><i class="fas fa-check"></i></span>
          <span class="switcher-label-off"><i class="fas fa-times"></i></span>
        </label>
      </div>
    </div>
  </div>
  <div class="my-3">
    <?= Html::submitButton('<i class="fas fa-save mr-2"></i>រក្សាទុក', ['class' => 'btn btn-lg  btn-primary px-5']) ?>

  </div>

  <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<<JS
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