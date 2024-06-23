<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
  'action' => ['agent-type'],
  'method' => 'get',
]); ?>


<div class="row">
  <div class="col-lg-3 offset-lg-6">
    <?= $form->field($model, 'globalSearch')->textInput(['class' => 'form-control pull-right', 'placeholder' => 'Search'])->label(false) ?>
  </div>
  <div class="col-lg-3">
    <div class="float-right">
      <button class="btn btn-success rounded-pill">
        Search <i class="bi bi-search"></i>
      </button>

      <a class="btn btn-warning rounded-pill" href="<?= Url::toRoute(['vendor/create-user']) ?>">
        Add New <i class="bi bi-plus-circle"></i>
      </a>
    </div>
  </div>
</div>




<?php ActiveForm::end(); ?>