<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = $model->isNewRecord ? 'New Role' : 'Update Role';
$this->params['pageTitle'] = $this->title;
?>

<div class="<?= $model->formName(); ?>">


  <?php $form = ActiveForm::begin(); ?>


  <div class="card">
    <div class="card-body">

      <div class="row">
        <div class="col-md-6">
          <div class="card-title"><?= Yii::t('app', 'Set role name') ?></div>
          <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
          <div class="card border border-warning">
            <div class="card-body">
              <span class="font-weight-semibold">Allow this role to be a master user of b2b frontend site.</span>
              <?= $form->field($model, 'is_master')->hiddenInput()->label(false); ?>
              <label class="switcher-control switcher-control-danger switcher-control-lg">
                <input type="checkbox" value="<?= $model->is_master ?>" id="itemStatus" class="switcher-input" <?= $model->is_master == 1 ? 'checked' : '' ?>>
                <span class="switcher-indicator"></span>
                <span class="switcher-label-on"><i class="fas fa-check"></i></span>
                <span class="switcher-label-off"><i class="fas fa-times"></i></span>
              </label>
            </div>
          </div>
          <div class="card-title"><?= Yii::t('app', 'Choose what this role can access') ?></div>

          <table class="table table-condensed">
            <thead class="thead-light">
              <tr>
                <th>Feature</th>
                <th>Capabilities</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (!empty($userRoleActionByGroup)) {
                foreach ($userRoleActionByGroup as $key => $value) {
              ?>
                  <tr>
                    <td><?= $key ?></td>
                    <td>
                      <?php
                      foreach ($value as $k => $v) {
                        $unique_key = 'chkboxAction_' . $key . $k;
                        $checked = $v['checked'] == 1 ? 'checked' : '';
                        $currentVal = '';
                        if ($v['checked'] == 1) {
                          $currentVal = $v['id'];
                        }
                        echo "<div class='custom-control custom-checkbox mb-1'>
                                <input {$checked} type='checkbox' class='custom-control-input chkboxAction' data-val='{$v['id']}' id='{$unique_key}'>
                                <input type='hidden' data-id='{$unique_key}' name='chkboxAction[]' value='{$currentVal}' />
                                <label class='custom-control-label' for='{$unique_key}'>{$v['name']}</label>
                              </div>";
                      }
                      ?>
                    </td>
                  </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>


          <?= Html::submitButton('<i class="far fa-save"></i> Save', ['class' => 'btn btn-success px-5 rounded-pill']) ?>
          <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>

  </div>

</div>

<?php

$script = <<<JS

  $(".chkboxAction").click(function(){
    var id = $(this).attr("id");
    var val = $(this).data("val");
    if($(this).is(":checked")){
      $("input[name='chkboxAction[]'][data-id='"+id+"']").val(val);
    }else{
      $("input[name='chkboxAction[]'][data-id='"+id+"']").val('');
    }
  });

  $("#itemStatus").change(function(){
      if($(this).is(":checked")){
          $("#userrole-is_master").val(1);
      }else{
          $("#userrole-is_master").val(0);
      }
  });

JS;

$this->registerJs($script);
?>