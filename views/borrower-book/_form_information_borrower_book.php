<?php

use app\assets\EditorAsset;
use app\models\Grade;
use app\modules\admin\models\BlogExperience;
use app\modules\admin\models\TourItineraryExperience;
use app\modules\admin\models\TourItineraryStyle;
use app\modules\admin\models\TourStyle;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;

EditorAsset::register($this);

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => 'Itinerary List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = empty($model->name) ? 'New Itinerary' : $model->name;

$base_url =  Yii::getAlias('@web');
$model->status = $model->isNewRecord ? 1 : $model->status;

?>
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

    $validationUrl = ['itinerary/validation'];
    if (!$model->isNewRecord) {
        $validationUrl['id'] = $model->id;
    }

    $form = ActiveForm::begin([
        'id' => 'form_detail',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        // 'options' => ['autocomplete' => 'off'],
        'validationUrl' => $validationUrl
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
                            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'gender')->dropDownList(['1' => 'male', 2 => 'female']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'grade_id',)->widget(Select2::class, [
                                'data' => ArrayHelper::map(Grade::find()->where(['status' => 1])->orderBy(['title' => SORT_ASC])->all(), 'id', 'title'),
                                'options' => ['placeholder' => 'Select a Grade...', 'class' => 'custom-select'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
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
    
    $("#itemStatus").change(function(){
        if($(this).is(":checked")){
            $("#touritinerary-status").val(1);
        }else{
            $("#touritinerary-status").val(0);
        }
        $("#submitButton").prop('disabled', false);
    });

    $("#blogImgStatus").change(function(){
        if($(this).is(":checked")){
            $("#touritinerary-is_best_seller").val(1);
        }else{
            $("#touritinerary-is_best_seller").val(0);
        }
        $("#submitButton").prop('disabled', false);
    });
JS;

$this->registerJs($script);
?>