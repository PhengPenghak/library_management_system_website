<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'សៀវភៅ';
// $this->params['pageTitle'] = $this->title;
?>
<style>
    .active {
        border-color: #346cb0 !important;
    }

    .badge-secondary-color {
        background-color: #346cb0;
    }
</style>
<div class="blog-index">
    <nav class="page-navs mb-5 px-0" style="background: none;">
        <div class="nav-scroller">
            <div class="nav nav-tabs">
                <a class="nav-link active" href="<?= Url::to(['book/index']) ?>">សៀវភៅទាំងអស់ <span class="badge badge-pill ml-2 badge-secondary-color text-light"><?= !empty($totalCount) ? $totalCount : '' ?></span></a>
            </div>
        </div>
    </nav>
    <?php Pjax::begin(['id' => 'book']); ?>
    <?= $this->render('_search', ['model' => $searchModel, 'categories' => $categories]); ?>
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
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'img_url',
                        'format' => ['image', ['width' => '70', 'height' => '70']],
                        'value' => function ($model) {
                            return $model->getThumb();
                        }
                    ],
                    'title',
                    [
                        'attribute' => 'quantity',
                        'value' => function ($model) {
                            return $model->quantity . ' ក្បាល';
                        },
                    ],
                    [
                        'attribute' => 'category_book_id',
                        'label' => 'បង្កើត​ឡើង​ដោយ',
                        'value' => function ($model) {
                            return $model->createdBy ? $model->createdBy->username : 'N/A';
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
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->getStatusTemp();
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => Yii::t('app', 'កែប្រែ'),
                        'headerOptions' => ['class' => 'text-center text-primary'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{update} {delete}',
                        'buttons' => [

                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-pen"></i>', $url, [
                                    'class' => 'btn btn-sm btn-icon btn-secondary',
                                    'title' => 'កែប្រែរឿង',
                                    'data' => [
                                        'pjax' => 0,
                                        'toggle' => 'tooltip',
                                    ],
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::button('<i class="bi bi-trash2"></i>', [
                                    'class' => 'btn btn-sm btn-icon btn-secondary button-delete',
                                    'title' => 'លុបរឿង',
                                    'method' => 'post',
                                    'data' => [
                                        'confirm' => 'តើអ្នកប្រាដកទេ?',
                                        'value' => Url::to(['delete', 'id' => $model->id]),
                                        'toggle' => 'tooltip',
                                    ]
                                ]);
                            }
                        ],

                    ],
                ],
            ]); ?>
        </div>
    </div>

    <?php Pjax::end(); ?>
</div>

<?php
$script = <<<JS

    $(document).on("click",".modalButton",function () {
        $("#modalDrawerRight").modal("show")
            .find("#modalContent")
            .load($(this).attr("value"));
        $("#modalDrawerRight").find("#modalDrawerRightLabel").text($(this).data("title"));
    });

    yii.confirm = function (message, okCallback, cancelCallback) {
        var val = $(this).data('value');
        console.log(val);
        
        if($(this).hasClass('button-delete')){
            Swal.fire({
                title: "ការព្រមាន!",
                text: "តើអ្នកចង់លុបសៀវភៅនេះឬ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'យល់ព្រម',
                cancelButtonText: 'បោះបង់'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(val);
                }
            });
        }

    };

JS;

$this->registerJs($script);

?>