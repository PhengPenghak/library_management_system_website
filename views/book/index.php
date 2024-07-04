<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Book';
$this->params['pageTitle'] = $this->title;
?>
<div class="blog-index">
    <?php Pjax::begin(['id' => 'book']); ?>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card">
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
                    [
                        'attribute' => 'img_url',
                        'format' => ['image', ['width' => '70', 'height' => '70']],
                        'value' => function ($model) {
                            return $model->getThumb();
                        }
                    ],
                    'title',
                    'quantity',
                    [
                        'attribute' => 'category_book_id',
                        'label' => 'Category Book',
                        'value' => function ($model) {
                            return $model->categoryBook ? $model->categoryBook->title : 'N/A';
                        },
                    ],


                    [
                        'attribute' => 'location_id',
                        'label' => 'Location Book',
                        'value' => function ($model) {
                            return $model->locationBook ? $model->locationBook->title : 'N/A';
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
                        'template' => '{update} {delete}',
                        'buttons' => [

                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-pen"></i>', $url, [
                                    'class' => 'btn btn-sm btn-icon btn-secondary',
                                    'title' => 'Update this item',
                                    'data' => [
                                        'pjax' => 0,
                                        'toggle' => 'tooltip',
                                    ],
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', Yii::getAlias("@web/book/"), [
                                    'class' => 'btn btn-sm btn-icon btn-secondary button-delete',
                                    'title' => 'Delete this item',
                                    'data' => [
                                        'pjax' => 0,
                                        'confirm' => 'Are you sure?',
                                        'value' => Url::toRoute(['book/delete', 'id' => $model->id]),
                                        'method' => 'post',
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

    <?php Pjax::end(); ?>
</div>