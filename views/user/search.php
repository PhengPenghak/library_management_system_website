<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
  'action' => ['index'],
  'method' => 'get',
]); ?>


<div class="d-flex px-0 justify-content-between col-12">

  <?= $form->field($model, 'globalSearch')->textInput(['class' => 'form-control pull-right', 'placeholder' => 'Search'])->label(false) ?>


  <div class="float-right">

    <a class="btn btn-warning" href="<?= Url::toRoute(['user/create']) ?>">
      <i class="bi bi-plus-square mr-2"></i>បង្កើតអ្នកប្រើប្រាស់ថ្មី
    </a>
  </div>

</div>




<?php ActiveForm::end(); ?>