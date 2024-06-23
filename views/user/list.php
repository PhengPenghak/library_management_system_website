<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'User List';
$this->params['pageTitle'] = $this->title;

?>
<div class="<?= Yii::$app->controller->action->id; ?>">

  <?= $this->render('_search_user', ['model' => $searchModel]); ?>

  <div class="card">
    <div class="card-body">

      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
          'class' => 'table table-hover',
          'id' => 'tableUser',
          'cellspacing' => '0',
          'width' => '100%',
        ],
        'rowOptions'   => function ($model, $key, $index, $grid) {
          return ['data-id' => $model->id, 'class' => 'cs-pointer'];
        },
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
          [
            'attribute' => 'email',
          ],
          [
            'attribute' => 'status',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'text-center', 'style' => 'min-width: 100px;'],
            'format' => 'raw',
            'value' => function ($model) {
              if ($model->status == 1) {
                return '<span class="badge badge-info">Active</span>';
              } else {
                return '<span class="badge badge-warning">Inactive</span>';
              }
            },
          ],
          [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'template' => '{delete}',
            'buttons' => [
              'delete' => function ($url, $model) {
                return Html::a('<i class="fas fa-trash"></i>', '#', [
                  'class' => "btn btn-sm btn-icon btn-secondary button-delete",
                  'data' => [
                    'toggle' => 'tooltip',
                    'title' => 'Delete this user',
                    'confirm' => 'Are you sure?',
                    'value' => Url::toRoute(['vendor/delete-user', 'id' => $model->id]),
                    'method' => 'post',
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
$this->registerJs("

$('#tableUser td').click(function (e) {
    var id = $(this).closest('tr').data('id');
    if(e.target == this)
        location.href = '" . Url::to(['vendor/update-user']) . "?id=' + id;
});

");
?>