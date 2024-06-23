<?php

use app\models\Promotion;
use app\models\VendorRegister;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/** @var \app\components\Formater $formater */
$formater = Yii::$app->formater;
?>
<header class="app-header app-header-dark">
    <div class="top-bar">
        <div class="top-bar-brand bg-transparent">
            <button class="hamburger hamburger-squeeze mr-2" type="button" data-toggle="aside-menu" aria-label="toggle aside menu">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                <img alt="dernham logo" src="<?= Yii::getAlias("@web/img/prointix_logo.png"); ?>" width="110px" />
                <!-- DERNHAM -->
            </a>
        </div>
        <div class="top-bar-list">
            <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
                <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside" aria-label="Menu">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
            <div class="top-bar-item top-bar-item-right px-0">
                <ul class="header-nav nav">

                </ul>
                <div class="dropdown d-sm-flex">
                    <button class="btn-account" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="user-avatar user-avatar-md">
                            <img src="<?= Yii::getAlias("@web"); ?>/img/profile_holder.jpeg" alt="">
                        </span>
                        <span class="account-summary pr-lg-4 d-none d-lg-block">
                            <span class="account-name"><?= Yii::$app->user->identity->name ?></span>
                            <span class="account-description"><?= Yii::$app->user->identity->role ?></span>
                        </span>
                    </button>
                    <div class="dropdown-menu">
                        <div class="dropdown-arrow d-lg-none" x-arrow=""></div>
                        <div class="dropdown-arrow ml-3 d-none d-lg-block"></div>
                        <h6 class="dropdown-header d-none d-sm-block d-lg-none"> <?= Yii::$app->user->identity->name ?> </h6>
                        <a class="dropdown-item" href="<?= Url::toRoute(['user/index']) ?>">
                            <span class="bi bi-person mr-2"></span> <?= Yii::t('app', 'Profile') ?>
                        </a>
                        <?php
                        if (Yii::$app->user->identity->role_id == 1) {
                        ?>
                            <a class="dropdown-item" href="<?= Url::toRoute(['user/list']) ?>">
                                <span class="bi bi-people mr-2"></span> <?= Yii::t('app', 'Manage User') ?>
                            </a>
                            <a class="dropdown-item" href="<?= Url::toRoute(['user/role']) ?>">
                                <span class="bi bi-people mr-2"></span> <?= Yii::t('app', 'Manage Role') ?>
                            </a>
                        <?php } ?>
                        <?= Html::a('<span class="bi-box-arrow-left mr-2"></span> ' . Yii::t('app', 'Log out'), ['#'], [
                            'class' => 'dropdown-item sign-out-user',
                            'data' => [
                                'confirm' => 'Are you sure, you want to Logout?',
                                'value' => Url::toRoute('site/logout'),
                                'method' => 'post',
                            ]
                        ]) ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><?= Yii::t('app', 'Help Center') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php
$base_url = Yii::getAlias("@web");
$script = <<<JS

    var base_url = "$base_url";

JS;
$this->registerJs($script);
?>