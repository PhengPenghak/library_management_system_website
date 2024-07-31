<?php

use app\models\UserRole;
use app\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = $model->isNewRecord ? 'បង្កើតអ្នកប្រើប្រាស់ថ្មី' : 'កែប្រែអ្នកប្រើប្រាស់ថ្មី';
// $this->params['pageTitle'] = $this->title;
echo Breadcrumbs::widget([
  'homeLink' => Yii::$app->params['breadcrumbs']['homeLink'],
  'links' => [
    ['label' => 'ព័ត៌មានទូទៅ', 'url' =>  Yii::$app->homeUrl],
    ['label' => 'អ្នកប្រើប្រាស់',  'url' =>  Url::to(['index'])],
    ['label' => $model->isNewRecord ? 'បង្កើតអ្នកប្រើប្រាស់ថ្មី' : 'កែប្រែអ្នកប្រើប្រាស់ថ្មី']
  ],
]);
?>
<hr class="border-0 pb-1">
<div class="<?= $model->formName(); ?>">


  <?php

  $validationUrl = ['user/validation'];
  if (!$model->isNewRecord) {
    $validationUrl['id'] = $model->id;
  }

  $form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    // 'options' => ['autocomplete' => 'off'],
    'validationUrl' => $validationUrl
  ]);
  ?>

  <div class="row">

    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <div class="card-title"><?= Yii::t('app', 'ប្រវត្តិរូប') ?></div>

          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label("គោត្តនាម") ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label("នាម") ?>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label("លេខទូរស័ព្ទ") ?>
            </div>
          </div>

          <hr>
          <div class="card-title"><?= Yii::t('app', 'សុវត្តិភាព') ?></div>

          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'email')->textInput(['type' => 'email'])->label("អ៊ីមែល") ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => $model->isNewRecord ? false : true])->label("ឈ្មោះក្រៅ") ?>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'password')->textInput(['type' => 'password'])->label("លេខសំងាត់") ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'confirm_password')->textInput(['type' => 'password'])->label("បញ្ជាក់លេខសំងាត់") ?>
            </div>
          </div>

        </div>

      </div>

    </div>
    <div class="col-md-5">
      <div class="card border border-warning">
        <div class="card-body">
          <div class="card-title"><?= Yii::t('app', 'កន្លែងកំណត់សិទ្ធអ្នកប្រើប្រាស់') ?></div>
          <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(UserRole::find()->all(), 'id', 'name'), ['prompt' => 'ជ្រើសរើសមួយ', 'class' => 'custom-select'])->label("សិទ្ធអ្នកប្រើប្រាស់") ?>
          <span class="font-weight-bold">ស្ថានភាព</span>
          <?= $form->field($model, 'status')->hiddenInput()->label(false); ?>
          <label class="switcher-control switcher-control-danger switcher-control-lg">
            <input type="checkbox" value="<?= $model->status ?>" id="itemStatus" class="switcher-input" <?= $model->status == 1 ? 'checked' : '' ?>>
            <span class="switcher-indicator"></span>
            <span class="switcher-label-on"><i class="fas fa-check"></i></span>
            <span class="switcher-label-off"><i class="fas fa-times"></i></span>
          </label>
        </div>
      </div>
    </div>
  </div>
  <?= Html::submitButton('<i class="far fa-save"></i> Save', ['class' => 'btn btn-success px-5 rounded-pill']) ?>
  <?php ActiveForm::end(); ?>
</div>

<?php

$script = <<<JS

    $("#itemStatus").change(function(){
        if($(this).is(":checked")){
            $("#user-status").val(1);
        }else{
            $("#user-status").val(0);
        }
    })   

JS;

$this->registerJs($script);
?>