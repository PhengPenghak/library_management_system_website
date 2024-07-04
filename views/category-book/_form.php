<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model->status = $model->isNewRecord ? 1 : $model->status;
?>

<div class="roomtype-form">
  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>
  <?= $form->field($model, 'sponse')->textInput(['autofocus' => true]) ?>

  <div class="card border border-warning">
    <div class="card-body">
      <div class="card-title"><?= Yii::t('app', 'Restriction Area') ?></div>

      <div class="d-flex justify-content-between align-items-center">
        <span class="font-weight-bold">Publish Post</span>
        <?= $form->field($model, 'status')->hiddenInput()->label(false); ?>
        <label class="switcher-control switcher-control-danger switcher-control-lg">
          <input type="checkbox" value="<?= $model->status ?>" id="categoryBook" class="switcher-input" <?= $model->status == 1 ? 'checked' : '' ?>>
          <span class="switcher-indicator"></span>
          <span class="switcher-label-on"><i class="fas fa-check"></i></span>
          <span class="switcher-label-off"><i class="fas fa-times"></i></span>
        </label>
      </div>
    </div>
  </div>
  <div class="d-flex flex-row-reverse my-3">
    <?= Html::submitButton('Save', ['class' => 'rounded-pill btn btn-warning font-weight-semibold px-5']) ?>
    <?= Html::button('Cancel', ['class' => 'rounded-pill btn btn-secondary font-weight-semibold px-5 mr-3', 'data-dismiss' => 'modal']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<<JS
  $("#categoryBook").change(function(){
    if($(this).is(":checked")){
        $("#categorybook-status").val(1);
    }else{
        $("#categorybook-status").val(0);
    }
  });

JS;
$this->registerJs($script);
?>