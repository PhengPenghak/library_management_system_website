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
    <div class="col-md-6">
        <?php $form = ActiveForm::begin([
            'action' => ['borrower-book'],
            'method' => 'get',
            'class' => 'form-inline'
        ]); ?>

        <div class="form-group">
            <?php
            if (!empty($searchModel)) { ?>
                <?= $form->field($searchModel, 'grade_id')->dropDownList(
                    InfomationBorrowerBookSearch::getGradeList(),
                    ['prompt' => 'Select Grade']
                )->label(false) ?>
            <?php    } else {
                echo 'no dataFound';
            }

            ?>

        </div>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => null,
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