<?php

use app\models\Vendor;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Reset password';

$vendor_arr = ArrayHelper::map(
  Vendor::find()
    ->innerJoin('user', 'user.id = vendor.user_id')
    ->orderBy(['vendor.name' => SORT_ASC])->all(),
  'id',
  function ($value) {
    return $value->code . ' | ' . $value->name;
  }
);
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
  <div class="col-lg-4">
    <div class="card">
      <div class="card-body">
        <mark class="card-title">Reset password</mark>
        <hr>
        <?= $form->field($model, 'vendor_id')->widget(Select2::class, [
          'data' => $vendor_arr,
          'theme' => Select2::THEME_BOOTSTRAP,
          'options' => ['placeholder' => 'Select'],
        ]);
        ?>
        <?= $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'secret_code')->textInput(['maxlength' => true, 'type' => 'password']) ?>
        <?= Html::submitButton('Reset Password', ['class' => 'btn btn-info btn-submit-base']) ?>
      </div>
    </div>
  </div>
</div>

<?php ActiveForm::end(); ?>