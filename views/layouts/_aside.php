<?php

use yii\helpers\Url;
use yii\helpers\Html;

/** @var \app\components\Master $master */
$master = Yii::$app->master;

$user_role_id = Yii::$app->user->identity->role_id;
$userRole = Yii::$app->db->createCommand("SELECT user_role_action.controller, user_role_action.action
    FROM user_role_permission
    INNER JOIN user_role_action ON user_role_action.id = user_role_permission.action_id
    WHERE user_role_id = :user_role_id", [
    ':user_role_id' => $user_role_id
])->queryAll();

$roleVendor = $master->arrayFilterByColumn($userRole, 'controller', 'vendor');
$roleMenu = $master->arrayFilterByColumn($userRole, 'controller', 'menu');
$rolePromotion = $master->arrayFilterByColumn($userRole, 'controller', 'promotion');
$roleBooking = $master->arrayFilterByColumn($userRole, 'controller', 'booking');
$rolePromocode = $master->arrayFilterByColumn($userRole, 'controller', 'promotion-code');
$roleReport = $master->arrayFilterByColumn($userRole, 'controller', 'report');
$roleResetPassword = $master->arrayFilterByColumn($userRole, 'controller', 'reset-password');
$roleAmenity = $master->arrayFilterByColumn($userRole, 'controller', 'amenity');
$roleTag = $master->arrayFilterByColumn($userRole, 'controller', 'tag');
$roleCancellation = $master->arrayFilterByColumn($userRole, 'controller', 'cancellation');
$roleCity = $master->arrayFilterByColumn($userRole, 'controller', 'city');
$roleZone = $master->arrayFilterByColumn($userRole, 'controller', 'zone');
$rolePrmotionBanner = $master->arrayFilterByColumn($userRole, 'controller', 'promotion-banner');
$roleNotificationCenter = $master->arrayFilterByColumn($userRole, 'controller', 'notification-center');
$roleAccounting = $master->arrayFilterByColumn($userRole, 'controller', 'vendor');

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$controller_action = $controller . '-' . $action;

$module = Yii::$app->controller->module->id;
$module_controller = $module . '-' . $controller;
$module_controller_action = $module . '-' . $controller . '-' . $action;

$controller_group = empty($this->params['controller_group']) ? '' : $this->params['controller_group'];
$controller_action_group = empty($this->params['controller_action_group']) ? '' : $this->params['controller_action_group'];
$menu_group =  empty($this->params['menu_group']) ? '' : $this->params['menu_group'];
$menu_group_type = empty($this->params['menu_group_type']) ? '' : $this->params['menu_group_type'];
?>

<aside class="app-aside app-aside-expand-md app-aside-light">
    <div class="aside-content">
        <header class="aside-header d-block d-md-none">
            <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside" aria-label="Menu">
                <span class="hamburger-box"><span class="hamburger-inner"></span></span>
            </button>
            <button class="btn-account d-flex d-md-none" type="button">
                Navigation Menu
            </button>

            <div class="top-bar-brand bg-primary">
                <a href="<?= Yii::$app->homeUrl ?>">
                    <img src="<?= Yii::getAlias("@web/img/prointix_logo.png"); ?>" width="120px" />
                </a>
            </div>
        </header>
        <div class="aside-menu overflow-hidden">
            <nav id="stacked-menu" class="stacked-menu">
                <ul class="menu">
                    <li class="menu-item py-1 <?= $controller == 'site' ? 'has-active' : ''; ?>">
                        <a href="<?= Yii::$app->homeUrl ?>" class="menu-link">
                            <span class="menu-icon bi bi-speedometer"></span>
                            <span class="menu-text"><?= Yii::t('app', 'Dashboard') ?></span>
                        </a>
                    </li>
                    <?php if (count($roleVendor) + count($roleMenu) + count($rolePromotion) > 0) { ?>
                        <li class="menu-item py-1 <?= $controller_group == 'vendor' ? 'has-active' : ''; ?>">
                            <a href="<?= Url::toRoute(['vendors/index']) ?>" class="menu-link">
                                <span class="menu-icon bi bi-shop"></span>
                                <span class="menu-text"><?= Yii::t('app', 'Vendor') ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="menu-item py-1 <?= $controller_group == 'page-template' ? 'has-active' : ''; ?>">
                        <a href="<?= Url::toRoute(['page-template/index']) ?>" class="menu-link">
                            <span class="menu-icon bi bi-card-list"></span>
                            <span class="menu-text">Templates</span>
                        </a>
                    </li>
                    <li class="menu-item py-1 has-child <?= $controller_group == 'website' ? 'has-active' : ''; ?>">
                        <a href="<?= Url::toRoute(['page-template/index']) ?>" class="menu-link">
                            <span class="menu-icon bi bi-globe"></span>
                            <span class="menu-text">Webiste</span>
                        </a>
                        <ul class="menu">
                            <li class="menu-item <?= $controller_action_group == 'website-header' ? 'has-active' : ''; ?> py-1">
                                <a href="<?= Url::toRoute(['website-header/index']) ?>" class="menu-link">
                                    Header
                                </a>
                            </li>
                            <li class="menu-item <?= $controller_action_group == 'website-footer' ? 'has-active' : ''; ?> py-1">
                                <a href="<?= Url::toRoute(['website-footer/index']) ?>" class="menu-link">
                                    Footer
                                </a>
                            </li>
                            <li class="menu-item <?= $controller_action_group == 'website-page' ? 'has-active' : ''; ?>">
                                <a href="<?= Url::toRoute(['page/page']) ?>" class="menu-link">
                                    Page
                                </a>
                            </li>
                        </ul>
                    </li>

                    <?php if (count($roleAccounting) > 0) { ?>
                        <li class="menu-item py-1 <?= $controller_group == 'accounting' ? 'has-active' : ''; ?> py-1 has-child">
                            <a href="#" class="menu-link">
                                <span class="menu-icon bi bi-cash-coin"></span>
                                <span class="menu-text"><?= Yii::t('app', 'Accounting') ?></span>
                            </a>
                            <ul class="menu">
                                <li class="menu-item <?= $controller_action == 'accounting-transaction' ? 'has-active' : ''; ?> py-1">
                                    <a href="<?= Yii::getAlias("@web/accounting/transaction") ?>" class="menu-link">Online Transaction</a>
                                </li>
                                <li class="menu-item <?= $controller_action == 'accounting-payment' ? 'has-active' : ''; ?> py-1">
                                    <a href="<?= Yii::getAlias("@web/accounting/payment") ?>" class="menu-link">Vendor Payment</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if (count($roleReport) > 0) { ?>
                        <li class="menu-item py-1 <?= $controller_group == 'report' ? 'has-active' : ''; ?> py-1 has-child">
                            <a href="#" class="menu-link">
                                <span class="menu-icon bi bi-graph-up-arrow"></span>
                                <span class="menu-text"><?= Yii::t('app', 'Report') ?></span>
                            </a>
                            <ul class="menu">
                                <li class="menu-item <?= $controller_action == 'report-booking' ? 'has-active' : ''; ?> py-1">
                                    <a href="<?= Yii::getAlias("@web/report/booking") ?>" class="menu-link">Booking</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if (count($roleResetPassword) + count($roleAmenity) + count($roleCancellation) + count($roleCity) + count($roleZone) > 0) { ?>
                        <li class="menu-item py-1 <?= $controller_group == 'setting' ? 'has-active' : ''; ?>  py-1 has-child">
                            <a href="#" class="menu-link">
                                <span class="menu-icon bi bi-sliders"></span>
                                <span class="menu-text"><?= Yii::t('app', 'Setting') ?></span>
                            </a>
                            <ul class="menu">
                                <?php if (count($roleResetPassword) > 0) { ?>
                                    <li class="menu-item <?= $controller_action == 'site-reset-password' ? 'has-active' : ''; ?> py-1">
                                        <a href="<?= Yii::getAlias("@web/site/reset-password") ?>" class="menu-link">Reset password</a>
                                    </li>
                                <?php } ?>
                                <li class="menu-item <?= $controller_action_group == 'setting-utilities' ? 'has-active' : ''; ?> py-1 has-child">
                                    <a href="#" class="menu-link">Utilities</a>
                                    <ul class="menu">
                                        <li class="menu-item <?= $controller == 'icon' ? 'has-active' : ''; ?> py-1">
                                            <a href="<?= Yii::getAlias("@web/icon") ?>" class="menu-link">Icon</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php if (count($roleAmenity) + count($roleTag) + count($roleCancellation)  > 0) { ?>
                                    <li class="menu-item <?= $controller_action_group == 'setting-base' ? 'has-active' : ''; ?> py-1 has-child">
                                        <a href="#" class="menu-link">Base</a>
                                        <ul class="menu">
                                            <?php if (count($roleAmenity) > 0) { ?>
                                                <li class="menu-item <?= $controller == 'bed-type' ? 'has-active' : ''; ?> py-1">
                                                    <a href="<?= Yii::getAlias("@web/bed-type") ?>" class="menu-link">Bed Type</a>
                                                </li>
                                            <?php } ?>
                                            <?php if (count($roleAmenity) > 0) { ?>
                                                <li class="menu-item <?= $controller == 'hotel-type' ? 'has-active' : ''; ?> py-1">
                                                    <a href="<?= Yii::getAlias("@web/hotel-type") ?>" class="menu-link">Hotel Type</a>
                                                </li>
                                            <?php } ?>
                                            <?php if (count($roleAmenity) > 0) { ?>
                                                <li class="menu-item <?= $controller == 'hotel-facility' ? 'has-active' : ''; ?> py-1">
                                                    <a href="<?= Yii::getAlias("@web/hotel-facility") ?>" class="menu-link">Facility</a>
                                                </li>
                                            <?php } ?>
                                            <?php if (count($roleAmenity) > 0) { ?>
                                                <li class="menu-item <?= $controller == 'hotel-facility-group' ? 'has-active' : ''; ?> py-1">
                                                    <a href="<?= Yii::getAlias("@web/hotel-facility-group") ?>" class="menu-link">Facility Group</a>
                                                </li>
                                            <?php } ?>
                                            <?php if (count($roleAmenity) > 0) { ?>
                                                <li class="menu-item <?= $controller == 'room-amenity' ? 'has-active' : ''; ?> py-1">
                                                    <a href="<?= Yii::getAlias("@web/room-amenity") ?>" class="menu-link">Room Amenity</a>
                                                </li>
                                            <?php } ?>
                                            <?php if (count($roleAmenity) > 0) { ?>
                                                <li class="menu-item <?= $controller == 'room-type' ? 'has-active' : ''; ?> py-1">
                                                    <a href="<?= Yii::getAlias("@web/room-type") ?>" class="menu-link">Room Type</a>
                                                </li>
                                            <?php } ?>
                                            <?php if (count($roleAmenity) > 0) { ?>
                                                <li class="menu-item <?= $controller == 'room-category' ? 'has-active' : ''; ?> py-1">
                                                    <a href="<?= Yii::getAlias("@web/room-category") ?>" class="menu-link">Room Category</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if (count($roleCity) + count($roleZone)  > 0) { ?>
                                    <li class="menu-item <?= $controller_action_group == 'setting-location' ? 'has-active' : ''; ?> py-1 has-child">
                                        <a href="#" class="menu-link">Location</a>
                                        <ul class="menu">
                                            <?php if (count($roleCity) > 0) { ?>
                                                <li class="menu-item <?= $controller == 'city' ? 'has-active' : ''; ?> py-1">
                                                    <a href="<?= Yii::getAlias("@web/city") ?>" class="menu-link">City</a>
                                                </li>
                                            <?php } ?>
                                            <?php if (count($roleZone) > 0) { ?>
                                                <li class="menu-item <?= $controller == 'zone' ? 'has-active' : ''; ?> py-1">
                                                    <a href="<?= Yii::getAlias("@web/zone") ?>" class="menu-link">Zone</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</aside>