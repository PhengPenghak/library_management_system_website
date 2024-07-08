<?php

use app\models\UserRole;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = $model->isNewRecord ? 'New User' : 'Update User';
$this->params['pageTitle'] = $this->title;
?>

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
          <div class="card-title"><?= Yii::t('app', 'Profile') ?></div>

          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
            </div>
          </div>

          <hr>
          <div class="card-title"><?= Yii::t('app', 'Security') ?></div>

          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => $model->isNewRecord ? false : true]) ?>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <?= $form->field($model, 'password')->textInput(['type' => 'password']) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'confirm_password')->textInput(['type' => 'password']) ?>
            </div>
          </div>

        </div>

      </div>

    </div>
    <div class="col-md-5">
      <div class="card border border-warning">
        <div class="card-body">
          <div class="card-title"><?= Yii::t('app', 'Restriction Area') ?></div>
          <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(UserRole::find()->all(), 'id', 'name'), ['prompt' => 'Choose one', 'class' => 'custom-select'])->label("User Role") ?>
          <span class="font-weight-bold">Status</span>
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