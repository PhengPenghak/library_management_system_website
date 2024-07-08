<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'User List';
$this->params['pageTitle'] = $this->title;

?>
<div class="<?= Yii::$app->controller->action->id; ?>">

    <?= $this->render('search', ['model' => $searchModel]); ?>

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
                    'username' => 'username',
                    [
                        'label' => 'Role',
                        'attribute' => 'role_id',
                        'value' => function ($model) {
                            return !empty($model->role) ? $model->role->name : 'not set';
                        },
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
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<i class="bi bi-pencil-square"></i>', ['user/update', 'id' => $model->id], ['class' => 'btn btn-sm btn-icon btn-secondary']);
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