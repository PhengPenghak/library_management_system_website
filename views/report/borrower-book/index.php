<?php

use app\models\InfomationBorrowerBookSearch;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InformationBorrowerBookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Search Information Borrower Books';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
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
                    'attribute' => 'grade_id',
                    'value' => function ($model) {
                        return $model->grade ? $model->grade->title : null;
                    },
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('app', 'Actions'),
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model, $id) {
                            return Html::a('<i class="far fa-eye"></i>', Url::to(["report/details", 'id' => $model->id]), [
                                'class' => 'btn btn-sm btn-icon btn-secondary',
                                'target' => '_blank',
                                'title' => 'View this item',
                                'data' => [
                                    'pjax' => 0,
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