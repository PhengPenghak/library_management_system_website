<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Role';
$this->params['pageTitle'] = $this->title;
?>


<div class="<?= Yii::$app->controller->action->id; ?>">

  <div class="row mb-3">
    <div class="col-lg-3 offset-lg-9">
      <div class="float-right">
        <a class="btn btn-warning rounded-pill" href="<?= Url::toRoute(['user/role-create']) ?>">
          Add New <i class="bi bi-plus-circle"></i>
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
          'id' => 'tableRole',
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
          'name',
        ],
      ]); ?>

    </div>
  </div>

</div>
<?php
$this->registerJs("

$('#tableRole td').click(function (e) {
    var id = $(this).closest('tr').data('id');
    if(e.target == this)
        location.href = '" . Url::to(['user/role-update']) . "?id=' + id;
});

");
?>