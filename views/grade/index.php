<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;


$this->title = 'Grade';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

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

                    'title',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->getStatusTemp();
                        }
                    ],
                    [
                        'class' => ActionColumn::class,
                        'header' => 'Action',
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::button('<i class="bi bi-pencil-square"></i>', ['data-title' => 'Update Cateogry Book', 'value' => $url, 'class' => 'btn btn-xs btn-warning modalButton']);
                            },
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