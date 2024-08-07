<?php

use app\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'ទីតាំងដាក់សៀវភៅ';
echo Breadcrumbs::widget([
    'homeLink' => Yii::$app->params['breadcrumbs']['homeLink'],
    'links' => [
        ['label' => 'ព័ត៌មានទូទៅ', 'url' =>  Yii::$app->homeUrl],
        ['label' => 'ទីតាំងដាក់សៀវភៅ'],
    ],
]);
?>
<div>

    <?= $this->render('_search', ['model' => $searchModel]); ?>
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

                    'title',

                    [
                        'attribute' => 'created_by',
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
                        'attribute' => 'category_book_id',
                        'label' => 'ចំនួនប្រើប្រាស់',
                        'headerOptions' => ['class' => 'text-primary'],
                        'value' => function ($model) {
                            return $model->bookCount ? Yii::$app->formater->maskNumberKH($model->bookCount) : 'មិនមានប្រើប្រាស់';
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
                        'class' => ActionColumn::class,
                        'header' => 'កែប្រែ',
                        'headerOptions' => ['class' => 'text-center text-primary'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::button('<i class="fas fa-pen"></i>', ['data-title' => 'កែប្រែប្រភេទសៀវភៅ', 'value' => $url, 'class' => 'btn btn-sm btn-icon btn-secondary modalButton']);
                            },
                            'delete' => function ($url, $model) {
                                $disabled = $model->isUsed() ? 'disabled' : '';
                                return Html::button('<i class="bi bi-trash2"></i>', [
                                    'class' => 'btn btn-sm btn-icon btn-secondary button-delete {$disabled}', 'disabled' => $model->isUsed(),
                                    'title' => 'លុបទីតាំងដាក់សៀវភៅ',
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

</div>
<?php
echo $this->render('//site/modal_scrollable');
$script = <<<JS

  $(document).on("click", ".modalButton", function() {
    $("#modalScrollable").modal("show")
      .find("#modalContent")
      .load($(this).attr("value"));
    $("#modalScrollable").find("#modalScrollableLabel").text($(this).data("title"));
  });

  $('#modalScrollable').on('hidden.bs.modal', function(e) {
    $("#modalContent").html("");
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