<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'របាយការណ៍ខ្ចីសៀវភៅតាមថ្នាក់';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h3><?= Html::encode($this->title) ?></h3>
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
                        'attribute' => 'grade_id',
                        'label' => 'ID ថ្នាក់', // Adjust label if needed
                        'value' => function ($model) {
                            return Html::encode($model['grade_id']); // Use Html::encode for security
                        },
                    ],
                    [
                        'attribute' => 'grade_title',
                        'format' => 'raw',
                        'label' => 'ឈ្មោះថ្នាក់', // Adjust label if needed
                        'value' => function ($model) {
                            return Html::encode($model['grade_title']); // Use Html::encode for security
                        },
                    ],
                    [
                        'attribute' => 'total_books',
                        'label' => 'ចំនួនសៀវភៅសរុប',
                        'value' => function ($model) {
                            return Html::encode($model['total_books']); // Use Html::encode for security
                        },
                    ],
                    [
                        'attribute' => 'total_quantity',
                        'label' => 'ចំនួយសៀវភៅ',
                        'value' => function ($model) {
                            return Html::encode($model['total_quantity']); // Use Html::encode for security
                        },
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => Yii::t('app', 'សកម្មភាព'),
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model, $id) {
                                return Html::a('<i class="far fa-eye"></i>', Url::to(["report/details", 'id' => $model['grade_id']]), [
                                    'class' => 'btn btn-sm btn-icon btn-secondary',
                                    'title' => 'View this item',
                                    'data' => [
                                        'pjax' => 0,
                                        'toggle' => 'tooltip',
                                    ],
                                ]);
                            },
                        ],

                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>