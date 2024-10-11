<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'របាយការណ៍អ្នកខ្ចីសៀវភៅ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-xl-12">
    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['id' => 'borrow-book']); ?>

    <div class="">
        <?php $form = ActiveForm::begin([
            'action' => ['details', 'id' => $id],
            'method' => 'get',
        ]); ?>

        <div class="card card-bg-default">
            <div class="card-body">
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
                        [
                            'attribute' => 'borrower_id',
                            'label' => 'Borrower Name',
                            'value' => function ($model) {
                                return $model->informationBorrowerBook ? $model->informationBorrowerBook->username : 'N/A';
                            },
                        ],
                        [
                            'attribute' => 'grade_title',
                            'label' => 'Grade Title',
                            'value' => function ($model) {
                                return $model->informationBorrowerBook && $model->informationBorrowerBook->grade ? $model->informationBorrowerBook->grade->title : 'N/A';
                            },
                        ],
                        [
                            'attribute' => 'book_id',
                            'label' => 'Book Title',
                            'value' => function ($model) {
                                return $model->book ? $model->book->title : 'N/A';
                            },
                        ],
                        'quantity',
                        [
                            'attribute' => 'start',
                            'format' => ['date', 'php:d/m/Y'],
                            'headerOptions' => ['style' => 'text-align: left;'],
                            'contentOptions' => ['style' => 'text-align: left;'],
                        ],
                        [
                            'attribute' => 'end',
                            'format' => ['date', 'php:d/m/Y'],
                            'headerOptions' => ['style' => 'text-align: left;'],
                            'contentOptions' => ['style' => 'text-align: left;'],
                        ],
                    ],
                ]); ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?php Pjax::end(); ?>
</div>


<?php
$script = <<<JS
JS;
$this->registerJs($script);
?>