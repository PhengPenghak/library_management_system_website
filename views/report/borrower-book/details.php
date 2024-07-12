<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\Url;

?>
<div class="col-xl-12">
    <div class="d-md-flex align-items-md-start pb-5">
        <h1 class="page-title mr-sm-auto"> Basic Table </h1>
        <div class="btn-toolbar">
            <?= Html::a('<i class="fas fa-file-pdf"></i> Export PDF', ['report/create-pdf', 'id' => $id], [
                'class' => 'btn btn-lg btn-light',
            ]) ?>

            <?= Html::a('<i class="fas fa-file-excel"></i> Export Excel', ['report/export-excel', 'id' => $id], [
                'class' => 'btn btn-lg btn-light',
            ]) ?>

        </div>

    </div>
    <?php
    $form = ActiveForm::begin([
        'action' => ['details', 'id' => $id],
        'method' => 'get',
    ]);
    ?>
    <?= $this->render('_search', ['searchModel' => $searchModel, 'id' => $id]) ?>

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