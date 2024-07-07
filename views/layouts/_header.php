<?php

use app\models\Promotion;
use app\models\VendorRegister;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/** @var \app\components\Formater $formater */
$formater = Yii::$app->formater;
?>
<style>
    .hamburger-inner,
    .hamburger-inner:after,
    .hamburger-inner:before {
        background-color: #fff;
    }
</style>
<header class="app-header app-header-dark">
    <div class="top-bar">
        <div class="top-bar-brand bg-transparent">
            <button class="hamburger hamburger-squeeze mr-2" style="color: white !important;" type="button" data-toggle="aside-menu" aria-label="toggle aside menu">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                <img alt="LMS-Logo-2 Logo" src="<?= Yii::getAlias("@web/img/LMS-Logo-2.png"); ?>" width="100%" />
            </a>
        </div>
        <div class="top-bar-list">
            <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
                <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside" aria-label="Menu">
                    <span class="hamburger-box">
                        <span class="hamburger-inner bg-light"></span>
                    </span>
                </button>
            </div>
            <div class="top-bar-item top-bar-item-right px-0">
                <ul class="header-nav nav">
                    <li class="nav-item dropdown header-nav-dropdown has-notified">
                        <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="oi oi-envelope-open"></span></a> <!-- .dropdown-menu -->
                        <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                            <div class="dropdown-arrow"></div>
                            <h6 class="dropdown-header stop-propagation">
                                <span>Messages</span> <a href="#">Mark all as read</a>
                            </h6>
                            <div class="dropdown-scroll perfect-scrollbar ps">

                                <a href="#" class="dropdown-item">
                                    <div class="tile tile-circle bg-green"> GZ </div>
                                    <div class="dropdown-item-body">
                                        <p class="subject"> Gogo Zoom </p>
                                        <p class="text text-truncate"> Live healthy with this wireless sensor. </p><span class="date">1 day ago</span>
                                    </div>
                                </a>
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                            <a href="page-messages.html" class="dropdown-footer">All messages <i class="fas fa-fw fa-long-arrow-alt-right"></i></a>
                        </div>
                    </li>
                </ul>
                <div class="dropdown d-sm-flex">
                    <button class="btn-account" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="user-avatar user-avatar-md">
                            <img src="<?= Yii::getAlias("@web"); ?>/img/profile_holder.jpeg" alt="">
                        </span>
                        <span class="account-summary pr-lg-4 d-none d-lg-block text-white">
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