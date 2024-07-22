<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\Url;

?>
<div class="col-xl-12">
    <h3><?= Html::encode($this->title) ?></h3>
    <div class="row my-5 body">
        <div class="col-lg-4 col-6 ">
            <div class="card border-success mt-2">
                <div class="card-body" id="countByDateType">
                    <h5 class="card-title ">Previous month tasks </h5>
                    <?= Html::dropDownList(
                        'dateFilter',
                        $datetype,
                        $drowdown,
                        ['class' => 'form-control dateFilter']
                    )
                    ?>
                    <h1 class="countingNumber"><?= $countByDateType ?></h1>
                </div>
            </div>
        </div>

    </div>
    <?php
    $form = ActiveForm::begin([
        'action' => ['details', 'id' => $id],
        'method' => 'get',
    ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover',
            'cellspacing' => '0',
            'width' => '100%',
        ],
        'layout' => "
                    <div class='table-responsive'>
                        {items}
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-md-6'>
                            {summary}
                        </div>
                        <div class='col-md-6'>
                            {pager}
                        </div>
                    </div>
                ",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code',
            'quantity',
            'start',
            'end',
            [
                'attribute' => 'username',
                'label' => 'Username',
                'value' => function ($model) {
                    return $model['username'];
                },
            ],
            [
                'attribute' => 'gender',
                'label' => 'Gender',
                'value' => function ($model) {
                    return $model['gender'];
                },
            ],
            [
                'attribute' => 'grade_title',
                'label' => 'Grade Title',
                'value' => function ($model) {
                    return $model['grade_title'];
                },
            ],
            [
                'attribute' => 'book_title',
                'label' => 'Book Title',
                'value' => function ($model) {
                    return $model['book_title'];
                },
            ],
        ],
    ]);
    ?>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs("
    $('#dateRange').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear'
        }
    });

    $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
");
?>