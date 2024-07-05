<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div class="formCategoryBookSearch">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'options' => ['data-pjax' => true, 'id' => 'formCategoryBookSearch', 'class' => 'customFormSearch'],
        'method' => 'get',
    ]); ?>
    <div class="d-flex justify-content-end">

        <div>
            <?= $form->field($model, 'globalSearch')->textInput(['class' => 'form-control form-control-lg globalSearch', 'placeholder' => 'ស្វែងដោយរកប្រភេទសៀវភៅ'])->label(false) ?>
        </div>
        <div class="ml-5">
            <button type="button" data-title="បញ្ចូលប្រភេទសៀវភៅ" value="<?= Url::to(['create']) ?>" class="btn btn-lg btn-primary modalButton"><i class="bi bi-plus-square mr-2"></i>បញ្ចូលប្រភេទថ្មី</button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<<JS

    $(document).on("change","#roomtypesearch-globalsearch", function(){
        $('#formCategoryBookSearch').trigger('submit');
    });

JS;
$this->registerJs($script);

?>