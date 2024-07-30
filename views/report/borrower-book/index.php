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
                        'value' => function ($model) {
                            return $model->grade ? $model->grade->title : null;
                        },
                    ],

                    [
                        'attribute' => 'created_at',
                        'label' => 'កាលបរិច្ឆេទបង្កើត',
                        'value' => function ($model) {
                            return Yii::$app->formater->maskDateKH($model->created_at);
                        }
                    ],

                    [
                        'attribute' => 'created_by',
                        'label' => 'បង្កើត​ឡើង​ដោយ',
                        'value' => function ($model) {
                            return $model->createdBy ? $model->createdBy->username : 'N/A';
                        },
                    ],

                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->getStatusTemp();
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => Yii::t('app', 'Actions'),
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model, $id) {
                                return Html::a('<i class="far fa-eye"></i>', Url::to(["report/details", 'id' => $model->id]), [
                                    'class' => 'btn btn-sm btn-icon btn-secondary',
                                    'target' => '_blank',
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