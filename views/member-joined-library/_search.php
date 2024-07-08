<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div class="formMemberJoinedLibrary">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'options' => ['data-pjax' => true, 'id' => 'formMemberJoinedLibrary', 'class' => 'customFormSearch'],
        'method' => 'get',
    ]); ?>
    <div class="d-flex justify-content-end">

        <div>
            <?= $form->field($model, 'globalSearch')->textInput(['class' => 'form-control form-control-lg globalSearch', 'placeholder' => 'ស្វែងរកថ្នាក់...'])->label(false) ?>
        </div>
        <div class="ml-5">
            <button type="button" data-title="បញ្ចូលអ្នកចូលអានសៀវភៅ" value="<?= Url::to(['form']) ?>" class="btn btn-lg btn-primary modalButton"><i class="bi bi-plus-square mr-2"></i>កត់ត្រាអ្នកអាន</span></button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<<JS

    $(document).on("change","#roomtypesearch-globalsearch", function(){
        $('#formMemberJoinedLibrary').trigger('submit');
    });

JS;
$this->registerJs($script);

?>