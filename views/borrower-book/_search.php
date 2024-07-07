<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>


<div class="row">
    <div class="col-lg-3">
        <?= $form->field($model, 'globalSearch')->textInput(['class' => 'form-control pull-right', 'placeholder' => 'ស្វែងរក​ដោយឈ្មោះ.....................'])->label(false) ?>
    </div>

    <div class="col-lg-9">
        <div class="float-right">
            <a data-title="Add Borrow Book" href="<?= Url::to(['create-information-borrower-book']) ?>" class="btn btn-lg btn-primary"><i class="bi bi-plus-square mr-2"></i>បង្កើត​<span class="d-none d-lg-inline">អ្នកខ្ចីសៀវភៅ</span></a>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>