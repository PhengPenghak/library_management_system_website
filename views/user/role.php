<?php

use app\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'ការកំណត់សិទ្ធ';
echo Breadcrumbs::widget([
  'homeLink' => Yii::$app->params['breadcrumbs']['homeLink'],
  'links' => [
    ['label' => 'ព័ត៌មានទូទៅ', 'url' =>  Yii::$app->homeUrl],
    ['label' => 'ការកំណត់សិទ្ធ'],
  ],
]);
?>


<div class="<?= Yii::$app->controller->action->id; ?>">

  <div class="row mb-3">
    <div class="col-lg-3 offset-lg-9">
      <div class="float-right">
        <a class="btn btn-primary btn-lg" href="<?= Url::toRoute(['user/role-create']) ?>">
          <i class="bi bi-plus-square mr-2"></i>បញ្ចូលសិទ្ធអ្នកប្រើប្រាស់ថ្មី
        </a>
      </div>
    </div>
  </div>

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
        'pager' => [
          'firstPageLabel' => 'First',
          'lastPageLabel' => 'Last',
          'maxButtonCount' => 5,
        ],

        'columns' => [
          ['class' => 'yii\grid\SerialColumn'],
          [
            'attribute' => 'name',
            'label' => 'ឈ្មោះសិទ្ធ'
          ],

          [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'កែប្រែ',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'template' => '{update}',
            'buttons' => [
              'update' => function ($url, $model) {
                return Html::a('<i class="bi bi-pencil-square"></i>', ['user/role-update', 'id' => $model->id], ['class' => 'btn btn-sm btn-icon btn-secondary']);
              },
              'delete' => function ($url, $model) {
                return Html::a('<i class="bi bi-trash2"></i>', '#', ['class' => 'btn btn-sm btn-icon btn-secondary']);
              }
            ],

          ],
        ],
      ]); ?>

    </div>
  </div>