<?php

use app\assets\EditorAsset;
use app\models\Grade;
use app\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

EditorAsset::register($this);

$this->title = 'ព័ត៌មានអ្នកចែកសៀវភៅ';
echo Breadcrumbs::widget([
    'homeLink' => Yii::$app->params['breadcrumbs']['homeLink'],
    'links' => [
        ['label' => 'ព័ត៌មានទូទៅ', 'url' =>  Yii::$app->homeUrl],
        ['label' => 'ចែកសៀវភៅតាមថ្នាក់', 'url' => ['index']],
        'label' => empty($model->username) ? 'បង្កើត ការចែកថ្មី' : $model->username
    ],
]);
$base_url =  Yii::getAlias('@web');
$model->status = $model->isNewRecord ? 1 : $model->status;

?>
<hr class="border-0 pb-1">
<style>
    .select2-selection--multiple .select2-selection__rendered {
        max-height: unset !important;
        overflow: hidden !important;
        height: auto !important;
    }

    input#pi9 {
        top: 0 !important;
    }

    .strikethrough {
        text-decoration: line-through;
    }
</style>
<div class="<?= $model->formName(); ?>">

    <?php
    $form = ActiveForm::begin([
        'id' => 'form_detail',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ]);
    ?>
    <div class="card card-fluid">
        <div class="card-header">
            <?= $this->render('_header', ['modelHeader' => $model]) ?>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active show">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'class' => 'form-control form-control-lg']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'gender')->dropDownList(
                                ['male' => 'ប្រុស', 'female' => 'ស្រី'],
                                ['class' => 'form-control form-control-lg']
                            ) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'grade_id',)->widget(Select2::class, [
                                'data' => ArrayHelper::map(Grade::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title'),
                                'options' => ['placeholder' => 'ជ្រើសរើសថ្នាក់...', 'class' => 'custom-select'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>

                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <span class="font-weight-bold">ស្ថានភាព</span>
                                        <?= $form->field($model, 'status')->hiddenInput(['value' => !empty($model->status) ? $model->status : 0])->label(false); ?>
                                        <label class="switcher-control switcher-control-danger switcher-control-lg">
                                            <input type="checkbox" value="<?= $model->status ?>" id="book" class="switcher-input" <?= $model->status == 1 ? 'checked' : '' ?>>
                                            <span class="switcher-indicator"></span>
                                            <span class="switcher-label-on"><i class="fas fa-check"></i></span>
                                            <span class="switcher-label-off"><i class="fas fa-times"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-end">
        <div class="col-lg-3">
            <?= Html::submitButton('<i class="fas fa-save mr-2"></i>Save', ['class' => 'btn btn-lg btn-block btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php

$script = <<<JS

    $("#book").change(function(){
        if($(this).is(":checked")){
            $("#infomationborrowerbook-status").val(1);
        }else{
            $("#infomationborrowerbook-status").val(0);
        }
    });
JS;

$this->registerJs($script);
?>