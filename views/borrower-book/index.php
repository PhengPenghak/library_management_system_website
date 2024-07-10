<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Modal;
use yii\grid\GridView;

$this->title = "អ្នកខ្ចីសៀវភៅ";

/** @var \app\components\Formter $formater */
$formater = Yii::$app->formater;
?>

<style>
    .active {
        border-color: #346cb0 !important;
    }

    .badge-secondary-color {
        background-color: #346cb0;
    }
</style>
<nav class="page-navs mb-5 px-0" style="background: none;">
    <!-- .nav-scroller -->
    <div class="nav-scroller">
        <!-- .nav -->
        <div class="nav nav-tabs">
            <a class="nav-link active" href="<?= Url::to(['borrower-book/index']) ?>">ខ្ចី័ និង​ សង<span class="badge badge-pill ml-2 badge-secondary-color text-light"><?= !empty($totalCount) ? $totalCount : '' ?></span></a>
            <a class="nav-link" href="<?= Url::to(['book-distribution/index']) ?>">ចែកសៀវទៅតាមថ្នាក់</a>
        </div><!-- /.nav -->
    </div><!-- /.nav-scroller -->
</nav>
<div class="itinerary">

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card card-bg-default">
        <div class="card-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'rowOptions'   => function ($model) {
                    return ['data-id' => $model->id, 'class' => 'cs-pointer'];
                },
                'tableOptions' => [
                    'id' => 'tableItinerary',
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
                'pager' => [
                    'firstPageLabel' => 'First',
                    'lastPageLabel' => 'Last',
                    'maxButtonCount' => 5,
                ],

                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'username',
                    'gender',
                    [
                        'attribute' => 'grade_id',
                        'value' => function ($model) {
                            return $model->grade ? $model->grade->title : 'No grade';
                        },
                    ],

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
                        'attribute' => 'status',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['class' => 'text-center', 'style' => 'min-width: 100px;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->getStatusTemp();
                        },
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'សកម្មភាព',
                        'headerOptions' => ['class' => 'text-center', 'style' => 'min-width: 100px'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{options}',
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<i class="bi bi-pencil-square"></i>', ['borrower-book/detail', 'id' => $model->id], ['class' => 'btn btn-sm btn-icon btn-secondary']);
                            },

                        ],

                    ],
                ],
            ]); ?>

        </div>
    </div>
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
        
        if($(this).hasClass('button-delete')){
            Swal.fire({
                title: "Warning!",
                text: "Are you sure you want to delete this record?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(val);
                }
            });
        }

    };

JS;

$this->registerJs($script);

$this->registerJs("

  $('#tableItinerary td').click(function (e) {
      var code = $(this).closest('tr').data('id');
      if(e.target == this)
          location.href = '" . Url::to(['itinerary/detail']) . "?code=' + code;
  });

");
?>