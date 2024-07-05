<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'ប្រភេទសៀវភៅ';
$this->params['breadcrumbs'][] = $this->title;
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
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->getStatusTemp();
                        }
                    ],
                    [
                        'attribute' => 'category_book_id',
                        'label' => 'ចំនួនប្រើប្រាស់',
                        'value' => function ($model) {
                            return $model->bookCount ? $model->bookCount  : 'មិនមានប្រើប្រាស់';
                        },
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

JS;
$this->registerJs($script);
?>