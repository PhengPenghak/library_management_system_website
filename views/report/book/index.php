<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'របាយការណ៍សៀវភៅ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_search', [
        'model' => $searchModel,
    ]); ?>
    <hr class="border-0">
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
                    [
                        'attribute' => 'id',
                        'label' => 'លេខសារពើភ័ណ្ឌ', // Adjust label if needed
                        'value' => function ($model) {
                            return Html::encode($model['id']); // Use Html::encode for security
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'ថ្ងៃខែឆ្នាំចូល', // Adjust label if needed
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDate($model['created_at'], 'php:Y-m-d');
                        },
                    ],

                    [
                        'attribute' => 'author',
                        'format' => 'raw',
                        'label' => 'ឈ្មោះអ្នកនិពន្ធ', // Adjust label if needed
                        'value' => function ($model) {
                            return Html::encode($model['author']); // Use Html::encode for security
                        },
                    ],
                    [
                        'attribute' => 'title',
                        'format' => 'raw',
                        'label' => 'ចំណងជើងសៀវភៅ', // Adjust label if needed
                        'value' => function ($model) {
                            return Html::encode($model['title']); // Use Html::encode for security
                        },
                    ],
                    [
                        'attribute' => 'publishing',
                        'label' => 'គ្រឹះស្ថានបោះពុម្ភ',
                        'value' => function ($model) {
                            return Html::encode($model['publishing']); // Use Html::encode for security
                        },
                    ],
                    [
                        'attribute' => 'code',
                        'label' => 'លេខកូដសៀវភៅ',
                        'value' => function ($model) {
                            return Html::encode($model['code']); // Use Html::encode for security
                        },
                    ],
                    [
                        'attribute' => 'sponse',
                        'label' => 'ប្រភពផ្ដល់',
                        'value' => function ($model) {
                            return Html::encode($model['sponse']); // Use Html::encode for security
                        },
                    ],
                    [
                        'attribute' => 'quantity',
                        'label' => 'សរុប',
                        'value' => function ($model) {
                            return Html::encode($model['quantity']) . ' ក្បាល'; // Use Html::encode for security
                        },
                    ],


                ],
            ]); ?>
        </div>
    </div>

</div>