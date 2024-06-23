<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\SweetAlert2Asset;
use yii\helpers\Url;

SweetAlert2Asset::register($this);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/img/fav.png" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script>
        var skin = localStorage.getItem('skin') || 'default';
        var disabledSkinStylesheet = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
        disabledSkinStylesheet.setAttribute('rel', '');
        disabledSkinStylesheet.setAttribute('disabled', true);
        document.querySelector('html').classList.add('loading');
    </script>
    <style>
        .auth {
            background-size: cover;
            background-image: linear-gradient(rgba(0, 0, 0, .1), rgba(0, 0, 0, .1)), url("<?= Yii::getAlias('@web') ?>/img/login_background.webp");
        }
    </style>
</head>

<body>
    <?php $this->beginBody() ?>

    <main class="auth">
        <header id="auth-header" class="auth-header bg-transparent">
            <h1>
                <img src="<?= Yii::getAlias("@web/img/prointix_logo.png"); ?>" width="300px" />
                <span class="sr-only">Sign In</span>
                <div class="py-3"></div>
            </h1>
        </header>
        <?= $content ?>

    </main>

    <?php $this->endBody() ?>
</body>

</html>
<?= $this->render('_toast') ?>
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
</script>
<?php $this->endPage() ?>