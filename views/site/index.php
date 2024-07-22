<?php

use app\assets\DateRangePickerAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

DateRangePickerAsset::register($this);

$base_url = Yii::getAlias("@web");
/** @var \app\components\Formater $formater */
$formater = Yii::$app->formater;

$this->title = 'Library - Management System Dashboard';
?>

<style>
    .bg-card-warning {
        background-color: #FFC122;
    }

    .bg-card-primary {
        background-color: #3B5998;
    }

    .bg-card-warning *,
    .bg-card-primary * {
        color: #fff !important;
    }

    .bg-card-danger {
        background-color: #FC5F55;
    }

    .bg-card-danger * {
        color: #fff !important;
    }

    .bg-card-info {
        background-color: #34A853;
    }

    .bg-card-info * {
        color: #fff !important;
    }

    .border-icon-cus {
        padding-top: 8px;
        font-size: 1rem;
        width: 50px;
        height: 50px;
        text-align: center;
        display: table;
        vertical-align: middle;
        position: absolute;
        border-radius: 50%;
        border: 1px solid #fff;

    }

    .custom-divider {
        border: none;
        border-left: 1px solid hsl(0deg 0% 88.35%);
        width: 1px;
    }

    .border-icon-cus svg path {
        fill: #ffffff;
    }
</style>
<div class="row">
    <div class="col-lg-4">
        <div class="card text-black bg-card-warning">
            <div class="card-body border border-warning">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="border-icon-cus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="24" viewBox="0 0 29 24" fill="none">
                                <path d="M1.7998 3.96386C3.34852 3.31676 5.56913 2.61964 7.72824 2.40186C10.0563 2.16704 12.031 2.51226 13.1748 3.71735V20.7726C11.5387 19.845 9.46594 19.7177 7.55262 19.9107C5.48693 20.1191 3.40579 20.7176 1.7998 21.3299V3.96386ZM14.9248 3.71735C16.0686 2.51226 18.0433 2.16704 20.3714 2.40186C22.5305 2.61964 24.7511 3.31676 26.2998 3.96386V21.3299C24.6938 20.7176 22.6127 20.1191 20.547 19.9107C18.6337 19.7177 16.5609 19.845 14.9248 20.7726V3.71735ZM14.0498 2.13597C12.3262 0.654424 9.82676 0.431314 7.55262 0.660695C4.90294 0.927954 2.22783 1.83722 0.562727 2.59408C0.250357 2.73607 0.0498047 3.04753 0.0498047 3.39065V22.6407C0.0498047 22.9382 0.200963 23.2153 0.451092 23.3763C0.701221 23.5374 1.01605 23.5603 1.28688 23.4372C2.83011 22.7358 5.31751 21.895 7.72824 21.6519C10.1922 21.4033 12.2604 21.8045 13.3665 23.1873C13.5326 23.3948 13.784 23.5157 14.0498 23.5157C14.3156 23.5157 14.567 23.3948 14.7331 23.1873C15.8392 21.8045 17.9074 21.4033 20.3714 21.6519C22.7821 21.895 25.2695 22.7358 26.8127 23.4372C27.0836 23.5603 27.3984 23.5374 27.6485 23.3763C27.8986 23.2153 28.0498 22.9382 28.0498 22.6407V3.39065C28.0498 3.04753 27.8493 2.73607 27.5369 2.59408C25.8718 1.83722 23.1967 0.927954 20.547 0.660695C18.2729 0.431314 15.7734 0.654424 14.0498 2.13597Z" fill="#4A4A4A" />
                            </svg>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card-title">
                            <h3>សៀវភៅខ្ចីសរុប</h3>
                            <h4 class="text-muted"> + <?= $totalCountOver ?></h4>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card text-black bg-card-danger">
            <div class="card-body border border-danger">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="border-icon-cus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
                                <path d="M6.17432 0.0495605C6.65757 0.0495605 7.04932 0.441311 7.04932 0.924561V1.79956H21.0493V0.924561C21.0493 0.441311 21.4411 0.0495605 21.9243 0.0495605C22.4076 0.0495605 22.7993 0.441311 22.7993 0.924561V1.79956H24.5493C26.4823 1.79956 28.0493 3.36656 28.0493 5.29956V24.5496C28.0493 26.4826 26.4823 28.0496 24.5493 28.0496H3.54932C1.61632 28.0496 0.0493164 26.4826 0.0493164 24.5496V5.29956C0.0493164 3.36656 1.61632 1.79956 3.54932 1.79956H5.29932V0.924561C5.29932 0.441311 5.69107 0.0495605 6.17432 0.0495605ZM1.79932 7.04956V24.5496C1.79932 25.5161 2.58282 26.2996 3.54932 26.2996H24.5493C25.5158 26.2996 26.2993 25.5161 26.2993 24.5496V7.04956H1.79932Z" fill="#4A4A4A" />
                            </svg>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card-title">
                            <h3>សៀវភៅមិនទាន់សង</h3>
                            <h4 class="text-muted"> + <?= $totalCount ?></h4>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card text-black bg-card-info">
            <div class="card-body border border-success">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="border-icon-cus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="22" viewBox="0 0 29 22" fill="none">
                                <path d="M26.2993 21.5496C26.2993 21.5496 28.0493 21.5496 28.0493 19.7996C28.0493 18.0496 26.2993 12.7996 19.2993 12.7996C12.2993 12.7996 10.5493 18.0496 10.5493 19.7996C10.5493 21.5496 12.2993 21.5496 12.2993 21.5496H26.2993ZM12.3384 19.7996C12.3324 19.7989 12.3239 19.7977 12.3136 19.796C12.3087 19.7952 12.304 19.7944 12.2993 19.7935C12.3019 19.3314 12.5913 17.9916 13.628 16.7822C14.5977 15.6509 16.294 14.5496 19.2993 14.5496C22.3046 14.5496 24.001 15.6509 24.9706 16.7822C26.0073 17.9916 26.2968 19.3314 26.2993 19.7935C26.2947 19.7944 26.2899 19.7952 26.2851 19.796C26.2748 19.7977 26.2663 19.7989 26.2602 19.7996H12.3384Z" fill="#4A4A4A" />
                                <path d="M19.2993 9.29956C21.2323 9.29956 22.7993 7.73256 22.7993 5.79956C22.7993 3.86656 21.2323 2.29956 19.2993 2.29956C17.3663 2.29956 15.7993 3.86656 15.7993 5.79956C15.7993 7.73256 17.3663 9.29956 19.2993 9.29956ZM24.5493 5.79956C24.5493 8.69906 22.1988 11.0496 19.2993 11.0496C16.3998 11.0496 14.0493 8.69906 14.0493 5.79956C14.0493 2.90007 16.3998 0.549561 19.2993 0.549561C22.1988 0.549561 24.5493 2.90007 24.5493 5.79956Z" fill="#4A4A4A" />
                                <path d="M12.1872 13.2895C11.5435 13.0836 10.8285 12.9339 10.0353 12.8574C9.64273 12.8195 9.23101 12.7996 8.79932 12.7996C1.79932 12.7996 0.0493164 18.0496 0.0493164 19.7996C0.0493164 20.9662 0.63265 21.5496 1.79932 21.5496H9.17795C8.93155 21.0524 8.79932 20.4631 8.79932 19.7996C8.79932 18.0316 9.4595 16.2261 10.7065 14.7179C11.1325 14.2026 11.6271 13.722 12.1872 13.2895ZM8.65939 14.5504C7.61379 16.1484 7.04932 17.9703 7.04932 19.7996H1.79932C1.79932 19.3433 2.08674 17.997 3.12802 16.7822C4.08251 15.6686 5.74118 14.584 8.65939 14.5504Z" fill="#4A4A4A" />
                                <path d="M2.67432 6.67456C2.67432 3.77507 5.02482 1.42456 7.92432 1.42456C10.8238 1.42456 13.1743 3.77507 13.1743 6.67456C13.1743 9.57406 10.8238 11.9246 7.92432 11.9246C5.02482 11.9246 2.67432 9.57406 2.67432 6.67456ZM7.92432 3.17456C5.99132 3.17456 4.42432 4.74156 4.42432 6.67456C4.42432 8.60756 5.99132 10.1746 7.92432 10.1746C9.85731 10.1746 11.4243 8.60756 11.4243 6.67456C11.4243 4.74156 9.85731 3.17456 7.92432 3.17456Z" fill="#4A4A4A" />
                            </svg>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card-title">
                            <h3>អ្នកអានសៀវភៅសរុប</h3>
                            <h4 class="text-muted"> + <?= $memberJoinedLibrary ?></h4>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card text-black bg-card-primary">
            <div class="card-body border border-success">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="border-icon-cus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="22" viewBox="0 0 29 22" fill="none">
                                <path d="M26.2993 21.5496C26.2993 21.5496 28.0493 21.5496 28.0493 19.7996C28.0493 18.0496 26.2993 12.7996 19.2993 12.7996C12.2993 12.7996 10.5493 18.0496 10.5493 19.7996C10.5493 21.5496 12.2993 21.5496 12.2993 21.5496H26.2993ZM12.3384 19.7996C12.3324 19.7989 12.3239 19.7977 12.3136 19.796C12.3087 19.7952 12.304 19.7944 12.2993 19.7935C12.3019 19.3314 12.5913 17.9916 13.628 16.7822C14.5977 15.6509 16.294 14.5496 19.2993 14.5496C22.3046 14.5496 24.001 15.6509 24.9706 16.7822C26.0073 17.9916 26.2968 19.3314 26.2993 19.7935C26.2947 19.7944 26.2899 19.7952 26.2851 19.796C26.2748 19.7977 26.2663 19.7989 26.2602 19.7996H12.3384Z" fill="#4A4A4A" />
                                <path d="M19.2993 9.29956C21.2323 9.29956 22.7993 7.73256 22.7993 5.79956C22.7993 3.86656 21.2323 2.29956 19.2993 2.29956C17.3663 2.29956 15.7993 3.86656 15.7993 5.79956C15.7993 7.73256 17.3663 9.29956 19.2993 9.29956ZM24.5493 5.79956C24.5493 8.69906 22.1988 11.0496 19.2993 11.0496C16.3998 11.0496 14.0493 8.69906 14.0493 5.79956C14.0493 2.90007 16.3998 0.549561 19.2993 0.549561C22.1988 0.549561 24.5493 2.90007 24.5493 5.79956Z" fill="#4A4A4A" />
                                <path d="M12.1872 13.2895C11.5435 13.0836 10.8285 12.9339 10.0353 12.8574C9.64273 12.8195 9.23101 12.7996 8.79932 12.7996C1.79932 12.7996 0.0493164 18.0496 0.0493164 19.7996C0.0493164 20.9662 0.63265 21.5496 1.79932 21.5496H9.17795C8.93155 21.0524 8.79932 20.4631 8.79932 19.7996C8.79932 18.0316 9.4595 16.2261 10.7065 14.7179C11.1325 14.2026 11.6271 13.722 12.1872 13.2895ZM8.65939 14.5504C7.61379 16.1484 7.04932 17.9703 7.04932 19.7996H1.79932C1.79932 19.3433 2.08674 17.997 3.12802 16.7822C4.08251 15.6686 5.74118 14.584 8.65939 14.5504Z" fill="#4A4A4A" />
                                <path d="M2.67432 6.67456C2.67432 3.77507 5.02482 1.42456 7.92432 1.42456C10.8238 1.42456 13.1743 3.77507 13.1743 6.67456C13.1743 9.57406 10.8238 11.9246 7.92432 11.9246C5.02482 11.9246 2.67432 9.57406 2.67432 6.67456ZM7.92432 3.17456C5.99132 3.17456 4.42432 4.74156 4.42432 6.67456C4.42432 8.60756 5.99132 10.1746 7.92432 10.1746C9.85731 10.1746 11.4243 8.60756 11.4243 6.67456C11.4243 4.74156 9.85731 3.17456 7.92432 3.17456Z" fill="#4A4A4A" />
                            </svg>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card-title">
                            <h3>សៀវភៅសរុប</h3>
                            <h4 class="text-muted"> + <?= $QTYBook ?></h4>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card text-black bg-success">
            <div class="card-body border border-success">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="border-icon-cus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="22" viewBox="0 0 29 22" fill="none">
                                <path d="M26.2993 21.5496C26.2993 21.5496 28.0493 21.5496 28.0493 19.7996C28.0493 18.0496 26.2993 12.7996 19.2993 12.7996C12.2993 12.7996 10.5493 18.0496 10.5493 19.7996C10.5493 21.5496 12.2993 21.5496 12.2993 21.5496H26.2993ZM12.3384 19.7996C12.3324 19.7989 12.3239 19.7977 12.3136 19.796C12.3087 19.7952 12.304 19.7944 12.2993 19.7935C12.3019 19.3314 12.5913 17.9916 13.628 16.7822C14.5977 15.6509 16.294 14.5496 19.2993 14.5496C22.3046 14.5496 24.001 15.6509 24.9706 16.7822C26.0073 17.9916 26.2968 19.3314 26.2993 19.7935C26.2947 19.7944 26.2899 19.7952 26.2851 19.796C26.2748 19.7977 26.2663 19.7989 26.2602 19.7996H12.3384Z" fill="#4A4A4A" />
                                <path d="M19.2993 9.29956C21.2323 9.29956 22.7993 7.73256 22.7993 5.79956C22.7993 3.86656 21.2323 2.29956 19.2993 2.29956C17.3663 2.29956 15.7993 3.86656 15.7993 5.79956C15.7993 7.73256 17.3663 9.29956 19.2993 9.29956ZM24.5493 5.79956C24.5493 8.69906 22.1988 11.0496 19.2993 11.0496C16.3998 11.0496 14.0493 8.69906 14.0493 5.79956C14.0493 2.90007 16.3998 0.549561 19.2993 0.549561C22.1988 0.549561 24.5493 2.90007 24.5493 5.79956Z" fill="#4A4A4A" />
                                <path d="M12.1872 13.2895C11.5435 13.0836 10.8285 12.9339 10.0353 12.8574C9.64273 12.8195 9.23101 12.7996 8.79932 12.7996C1.79932 12.7996 0.0493164 18.0496 0.0493164 19.7996C0.0493164 20.9662 0.63265 21.5496 1.79932 21.5496H9.17795C8.93155 21.0524 8.79932 20.4631 8.79932 19.7996C8.79932 18.0316 9.4595 16.2261 10.7065 14.7179C11.1325 14.2026 11.6271 13.722 12.1872 13.2895ZM8.65939 14.5504C7.61379 16.1484 7.04932 17.9703 7.04932 19.7996H1.79932C1.79932 19.3433 2.08674 17.997 3.12802 16.7822C4.08251 15.6686 5.74118 14.584 8.65939 14.5504Z" fill="#4A4A4A" />
                                <path d="M2.67432 6.67456C2.67432 3.77507 5.02482 1.42456 7.92432 1.42456C10.8238 1.42456 13.1743 3.77507 13.1743 6.67456C13.1743 9.57406 10.8238 11.9246 7.92432 11.9246C5.02482 11.9246 2.67432 9.57406 2.67432 6.67456ZM7.92432 3.17456C5.99132 3.17456 4.42432 4.74156 4.42432 6.67456C4.42432 8.60756 5.99132 10.1746 7.92432 10.1746C9.85731 10.1746 11.4243 8.60756 11.4243 6.67456C11.4243 4.74156 9.85731 3.17456 7.92432 3.17456Z" fill="#4A4A4A" />
                            </svg>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card-title">
                            <h3 class="text-light">សៀវភៅនៅសល់</h3>
                            <h4 class="text-light"> + <?= $availableBooksCount ?></h4>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr class="border-0">
<div class="row">
    <div class="col-lg-6">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info" role="alert">
                        តារាងទិន្នន័យប្រចាំខែ
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <canvas id="borrowBookChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info" role="alert">
                        សម្រាប់ទិន្នន័យបម្រុងទុក
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= Html::a('ទិន្នន័យបម្រុងទុក', ['site/backup'], ['class' => 'btn btn-lg btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<hr class="border-0">
<h5 class="mt-5 mb-4">បញ្ចីអ្នកខ្ចីសៀវភៅមិនទាន់សង</h5>

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
                [
                    'attribute' => 'informationBorrowerBook.username',
                    'label' => 'ឈ្មោះ',
                    'headerOptions' => ['class' => 'text-primary'],

                ],

                [
                    'attribute' => 'informationBorrowerBook.gender',
                    'label' => 'ភេទ',
                    'headerOptions' => ['class' => 'text-primary'],

                ],
                [
                    'attribute' => 'book.title',
                    'headerOptions' => ['class' => 'text-primary'],

                ],

                [
                    'attribute' => 'title',
                    'label' => 'ថ្នាក់',
                    'headerOptions' => ['class' => 'text-primary'],

                    'value' => function ($model) {
                        return $model->informationBorrowerBook->grade->title;
                    },
                ],

                // [
                //     'attribute' => 'infomation_borrower_book.created_by',
                //     'label' => 'បង្កើត​ឡើង​ដោយ',
                //     'value' => function ($model) {
                //         return $model->createdBy ? $model->createdBy->username : 'N/A';
                //     },
                // ],

                [
                    'attribute' => 'borrow_book.end',
                    'label' => 'កាលបរិច្ឆេទខ្ចី',
                    'headerOptions' => ['class' => 'text-primary'],

                    'value' => function ($model) {
                        return Yii::$app->formater->maskDateKH($model->end);
                    }
                ],
                [
                    'attribute' => 'ផុតកំណត់',
                    'headerOptions' => ['class' => 'text-primary'],
                    'contentOptions' => ['style' => 'color:#FC5F55'],

                    'value' => function ($model) {
                        return  $model->getDaysAgo() == 0 ? 'ថ្ងៃនេះ' : Yii::$app->formater->maskNumberKH($model->getDaysAgo()) . ' ថ្ងៃ';
                    },
                ],

                // [
                //     'attribute' => 'status',
                //     'contentOptions' => ['class' => 'text-center'],
                //     'headerOptions' => ['class' => 'text-center', 'style' => 'min-width: 100px;'],
                //     'format' => 'raw',
                //     'value' => function ($model) {
                //         return $model->getStatusTemp();
                //     },
                // ],


            ],
        ]); ?>

    </div>
</div>

<hr class="border-0">
<h5 class="mt-5 mb-4">បញ្ចីអ្នកខ្ចីសៀវភៅ</h5>
<div class="card card-bg-default">
    <div class="card-body">

        <?= GridView::widget([
            'dataProvider' => $dataProviderOver,
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
                [
                    'attribute' => 'informationBorrowerBook.username',
                    'label' => 'ឈ្មោះ',
                    'headerOptions' => ['class' => 'text-primary'],

                ],

                [
                    'attribute' => 'informationBorrowerBook.gender',
                    'label' => 'ភេទ',
                    'headerOptions' => ['class' => 'text-primary'],

                ],
                [
                    'attribute' => 'book.title',
                    'headerOptions' => ['class' => 'text-primary'],

                ],

                [
                    'attribute' => 'title',
                    'label' => 'ថ្នាក់',
                    'headerOptions' => ['class' => 'text-primary'],

                    'value' => function ($model) {
                        return $model->informationBorrowerBook->grade->title;
                    },
                ],

                [
                    'attribute' => 'borrow_book.end',
                    'label' => 'កាលបរិច្ឆេទខ្ចី',
                    'headerOptions' => ['class' => 'text-primary'],

                    'value' => function ($model) {
                        return Yii::$app->formater->maskDateKH($model->end);
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


            ],
        ]); ?>

    </div>
</div>

<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', ['position' => View::POS_HEAD]);
$this->registerJsFile('https://code.jquery.com/jquery-3.5.1.min.js', ['position' => View::POS_HEAD]);
$baseUrl = Yii::getAlias("@web");


$js = <<< JS
$(document).ready(function() {
    $.ajax({
        url: '/library_management_system_website/site/chart-data', // URL to the action that provides chart data
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var ctx = document.getElementById('borrowBookChart').getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.months,

                        datasets: [{
                            label: 'Books Borrowed',
                            data: data.counts,
                           
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }],                        
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Count'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                console.error('Canvas element not found or not correctly initialized.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to fetch chart data:', error);
        }
    });
});
JS;
$this->registerJs($js);
?>