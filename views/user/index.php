<?php

use app\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'User List';
// $this->params['pageTitle'] = $this->title;
echo Breadcrumbs::widget([
    'homeLink' => Yii::$app->params['breadcrumbs']['homeLink'],
    'links' => [
        ['label' => 'ព័ត៌មានទូទៅ', 'url' =>  Yii::$app->homeUrl],
        ['label' => 'អ្នកប្រើប្រាស់'],
    ],
]);

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
                    [
                        'attribute' => 'username',
                        'label' => 'ឈ្មោះ​អ្នកប្រើប្រាស់',

                    ],
                    [
                        'label' => 'សិទ្ធអ្នកប្រើប្រាស់',
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
                        'label' => 'ស្ថានភាព',
                        'value' => function ($model) {
                            if ($model->status == 1) {
                                return '<span class="badge badge-info">នៅប្រើប្រាស់</span>';
                            } else {
                                return '<span class="badge badge-warning">ឈប់ប្រើប្រាស់</span>';
                            }
                        },
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
                                    'title' => 'Update this item',
                                    'data' => [
                                        'pjax' => 0,
                                        'toggle' => 'tooltip',
                                    ],
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', Yii::getAlias("@web/user/"), [
                                    'class' => 'btn btn-sm btn-icon btn-secondary button-delete',
                                    'title' => 'Delete this item',
                                    'data' => [
                                        'pjax' => 0,
                                        'confirm' => 'Are you sure?',
                                        'value' => Url::toRoute(['user/delete', 'id' => $model->id]),
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