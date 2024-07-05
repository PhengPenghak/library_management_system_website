<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model->status = $model->isNewRecord ? 1 : $model->status;
?>

<div class="grade-form">
  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'title')->textInput(['autofocus' => true])->label('ថ្នាក់') ?>

  <div class="card border">
    <div class="card-body">
      <div class="card-title"><?= Yii::t('app', 'ស្ថានភាព') ?></div>

      <div class="">
        <?= $form->field($model, 'status')->hiddenInput()->label(false); ?>
        <label class="switcher-control switcher-control-success switcher-control-lg">
          <input type="checkbox" value="<?= $model->status ?>" id="grade" class="switcher-input" <?= $model->status == 1 ? 'checked' : '' ?>>
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
  $("#grade").change(function(){
    if($(this).is(":checked")){
        $("#grade-status").val(1);
    }else{
        $("#grade-status").val(0);
    }
  });

JS;
$this->registerJs($script);
?>