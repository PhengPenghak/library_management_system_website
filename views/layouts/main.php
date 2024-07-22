<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\SweetAlert2Asset;
use yii\helpers\Url;

AppAsset::register($this);
SweetAlert2Asset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/img/2.png" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script>
        var skin = localStorage.getItem('skin') || 'default';
        var isCompact = JSON.parse(localStorage.getItem('hasCompactMenu'));
        var disabledSkinStylesheet = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
        // Disable unused skin immediately
        disabledSkinStylesheet.setAttribute('rel', '');
        disabledSkinStylesheet.setAttribute('disabled', true);
        // add flag class to html immediately
        if (isCompact == true) document.querySelector('html').classList.add('preparing-compact-menu');
    </script>

</head>

<body>
    <?php $this->beginBody() ?>

    <div class="app">

        <?= $this->render('_header'); ?>

        <?= $this->render('_aside'); ?>

        <main class="app-main">
            <div class="wrapper">
                <div class="page">
                    <div class="page-inner">
                        <?php if (isset($this->params['pageTitle'])) { ?>
                            <header class="page-title-bar mb-0">
                                <h1 class="page-title"> <?= $this->params['pageTitle'] ?></h1>
                            </header>
                        <?php } ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- .breadcrumb -->
                            <?= Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ]) ?>
                            <button type="button" class="btn btn-light btn-icon d-xl-none" data-toggle="sidebar"><i class="fa fa-angle-double-left"></i></button>
                        </div>
                        <div class="page-section">
                            <div class="section-block">
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?= $this->render('_toast') ?>
<?= $this->render('//site/modal_scrollable'); ?>
<script type="text/javascript">
    yii.confirm = function(message, okCallback, cancelCallback) {
        var val = $(this).data('value');

        if ($(this).hasClass('sign-out-user')) {

            Swal.fire({
                title: "Warning!",
                text: "Are you sure you want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Logout now!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(val); // <--- submit form programmatically
                }
            });
        } else {
            $.post(val);
        }
    };

    // $('.dropdown-toggle').dropdown();
</script>
<?php $this->endPage() ?>