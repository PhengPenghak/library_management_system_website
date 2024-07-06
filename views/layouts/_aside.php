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
                    <img src="<?= Yii::getAlias("@web/img/LMS-Logo-2.png"); ?>" width="120px" />
                </a>
            </div>
        </header>
        <div class="aside-menu overflow-hidden">
            <nav id="stacked-menu" class="stacked-menu">
                <ul class="menu">
                    <li class="menu-item py-1 <?= $controller == 'site' ? 'has-active' : ''; ?>">
                        <a href="<?= Yii::$app->homeUrl ?>" class="menu-link">
                            <span class="menu-icon bi bi-speedometer"></span>
                            <span class="menu-text"><?= Yii::t('app', 'ព័ត៌មានទូទៅ') ?></span>
                        </a>
                    </li>
                    <li class="menu-item py-1 <?= $controller_group == 'book' ? 'has-active' : ''; ?>">
                        <a href="<?= Url::toRoute(['book/index']) ?>" class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 29 24" fill="none">
                                    <path d="M1.8125 3.62548C3.41653 2.95527 5.71644 2.23325 7.95267 2.0077C10.3639 1.76449 12.4091 2.12204 13.5938 3.37016V21.0345C11.8993 20.0738 9.75243 19.942 7.77077 20.1419C5.63131 20.3576 3.47584 20.9776 1.8125 21.6118V3.62548ZM15.4062 3.37016C16.5909 2.12204 18.6361 1.76449 21.0473 2.0077C23.2836 2.23325 25.5835 2.95527 27.1875 3.62548V21.6118C25.5242 20.9776 23.3687 20.3577 21.2292 20.1419C19.2476 19.942 17.1007 20.0738 15.4062 21.0345V3.37016ZM14.5 1.73231C12.7148 0.197851 10.1261 -0.033227 7.77077 0.204345C5.02646 0.481149 2.25581 1.42289 0.531241 2.20678C0.207715 2.35384 0 2.67642 0 3.0318V22.9693C0 23.2774 0.156557 23.5645 0.415619 23.7313C0.674682 23.8981 1.00075 23.9218 1.28126 23.7943C2.8796 23.0678 5.45584 22.197 7.95267 21.9452C10.5046 21.6878 12.6467 22.1033 13.7923 23.5354C13.9643 23.7504 14.2247 23.8756 14.5 23.8756C14.7753 23.8756 15.0357 23.7504 15.2077 23.5354C16.3533 22.1033 18.4954 21.6878 21.0473 21.9452C23.5442 22.197 26.1204 23.0678 27.7187 23.7943C27.9992 23.9218 28.3253 23.8981 28.5844 23.7313C28.8434 23.5645 29 23.2774 29 22.9693V3.0318C29 2.67642 28.7923 2.35384 28.4688 2.20678C26.7442 1.42289 23.9735 0.481149 21.2292 0.204345C18.8739 -0.033227 16.2852 0.197851 14.5 1.73231Z" fill="#4A4A4A" />
                                </svg>
                            </span>
                            <span class="menu-text">សៀវភៅ</span>
                        </a>
                    </li>

                    <li class="menu-item py-1 <?= $controller_group == 'category-book' ? 'has-active' : ''; ?>">
                        <a href="<?= Url::toRoute(['category-book/index']) ?>" class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 31 28" fill="none">
                                    <path d="M28.0938 2.4375C28.6288 2.4375 29.0625 2.95517 29.0625 3.59375V24.4062C29.0625 25.0448 28.6288 25.5625 28.0938 25.5625H2.90625C2.37122 25.5625 1.9375 25.0448 1.9375 24.4062V3.59375C1.9375 2.95517 2.37122 2.4375 2.90625 2.4375H28.0938ZM2.90625 0.125C1.30117 0.125 0 1.67801 0 3.59375V24.4062C0 26.322 1.30117 27.875 2.90625 27.875H28.0938C29.6988 27.875 31 26.322 31 24.4062V3.59375C31 1.67801 29.6988 0.125 28.0938 0.125H2.90625Z" fill="#4A4A4A" />
                                    <path d="M5.8125 15.1562C5.8125 14.5177 6.24622 14 6.78125 14H24.2188C24.7538 14 25.1875 14.5177 25.1875 15.1562C25.1875 15.7948 24.7538 16.3125 24.2188 16.3125H6.78125C6.24622 16.3125 5.8125 15.7948 5.8125 15.1562ZM5.8125 19.7812C5.8125 19.1427 6.24622 18.625 6.78125 18.625H18.4062C18.9413 18.625 19.375 19.1427 19.375 19.7812C19.375 20.4198 18.9413 20.9375 18.4062 20.9375H6.78125C6.24622 20.9375 5.8125 20.4198 5.8125 19.7812Z" fill="#4A4A4A" />
                                    <path d="M5.8125 8.21875C5.8125 7.58017 6.24622 7.0625 6.78125 7.0625H24.2188C24.7538 7.0625 25.1875 7.58017 25.1875 8.21875V10.5312C25.1875 11.1698 24.7538 11.6875 24.2188 11.6875H6.78125C6.24622 11.6875 5.8125 11.1698 5.8125 10.5312V8.21875Z" fill="#4A4A4A" />
                                </svg>
                            </span>
                            <span class="menu-text">ប្រភេទសៀវភៅ</span>
                        </a>
                    </li>
                    <li class="menu-item py-1 <?= $controller_group == 'location-book' ? 'has-active' : ''; ?>">
                        <a href="<?= Url::toRoute(['location-book/index']) ?>" class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 31 28" fill="none">
                                    <path d="M28.0938 2.4375C28.6288 2.4375 29.0625 2.95517 29.0625 3.59375V24.4062C29.0625 25.0448 28.6288 25.5625 28.0938 25.5625H2.90625C2.37122 25.5625 1.9375 25.0448 1.9375 24.4062V3.59375C1.9375 2.95517 2.37122 2.4375 2.90625 2.4375H28.0938ZM2.90625 0.125C1.30117 0.125 0 1.67801 0 3.59375V24.4062C0 26.322 1.30117 27.875 2.90625 27.875H28.0938C29.6988 27.875 31 26.322 31 24.4062V3.59375C31 1.67801 29.6988 0.125 28.0938 0.125H2.90625Z" fill="#4A4A4A" />
                                    <path d="M5.8125 15.1562C5.8125 14.5177 6.24622 14 6.78125 14H24.2188C24.7538 14 25.1875 14.5177 25.1875 15.1562C25.1875 15.7948 24.7538 16.3125 24.2188 16.3125H6.78125C6.24622 16.3125 5.8125 15.7948 5.8125 15.1562ZM5.8125 19.7812C5.8125 19.1427 6.24622 18.625 6.78125 18.625H18.4062C18.9413 18.625 19.375 19.1427 19.375 19.7812C19.375 20.4198 18.9413 20.9375 18.4062 20.9375H6.78125C6.24622 20.9375 5.8125 20.4198 5.8125 19.7812Z" fill="#4A4A4A" />
                                    <path d="M5.8125 8.21875C5.8125 7.58017 6.24622 7.0625 6.78125 7.0625H24.2188C24.7538 7.0625 25.1875 7.58017 25.1875 8.21875V10.5312C25.1875 11.1698 24.7538 11.6875 24.2188 11.6875H6.78125C6.24622 11.6875 5.8125 11.1698 5.8125 10.5312V8.21875Z" fill="#4A4A4A" />
                                </svg>
                            </span>
                            <span class="menu-text">ទីតាំងដាក់សៀវភៅ</span>
                        </a>
                    </li>
                    <li class="menu-item py-1 <?= $controller_group == 'location-book' ? 'has-active' : ''; ?>">
                        <a href="<?= Url::toRoute(['grade/index']) ?>" class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 31 28" fill="none">
                                    <path d="M28.0938 2.4375C28.6288 2.4375 29.0625 2.95517 29.0625 3.59375V24.4062C29.0625 25.0448 28.6288 25.5625 28.0938 25.5625H2.90625C2.37122 25.5625 1.9375 25.0448 1.9375 24.4062V3.59375C1.9375 2.95517 2.37122 2.4375 2.90625 2.4375H28.0938ZM2.90625 0.125C1.30117 0.125 0 1.67801 0 3.59375V24.4062C0 26.322 1.30117 27.875 2.90625 27.875H28.0938C29.6988 27.875 31 26.322 31 24.4062V3.59375C31 1.67801 29.6988 0.125 28.0938 0.125H2.90625Z" fill="#4A4A4A" />
                                    <path d="M5.8125 15.1562C5.8125 14.5177 6.24622 14 6.78125 14H24.2188C24.7538 14 25.1875 14.5177 25.1875 15.1562C25.1875 15.7948 24.7538 16.3125 24.2188 16.3125H6.78125C6.24622 16.3125 5.8125 15.7948 5.8125 15.1562ZM5.8125 19.7812C5.8125 19.1427 6.24622 18.625 6.78125 18.625H18.4062C18.9413 18.625 19.375 19.1427 19.375 19.7812C19.375 20.4198 18.9413 20.9375 18.4062 20.9375H6.78125C6.24622 20.9375 5.8125 20.4198 5.8125 19.7812Z" fill="#4A4A4A" />
                                    <path d="M5.8125 8.21875C5.8125 7.58017 6.24622 7.0625 6.78125 7.0625H24.2188C24.7538 7.0625 25.1875 7.58017 25.1875 8.21875V10.5312C25.1875 11.1698 24.7538 11.6875 24.2188 11.6875H6.78125C6.24622 11.6875 5.8125 11.1698 5.8125 10.5312V8.21875Z" fill="#4A4A4A" />
                                </svg>
                            </span>
                            <span class="menu-text">ថ្នាក់</span>
                        </a>
                    </li>

                    <li class="menu-item py-1 <?= $controller_group == 'event' ? 'has-active' : ''; ?>">
                        <a href="<?= Url::toRoute(['event/index']) ?>" class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 29 30" fill="none">
                                    <path d="M6.34375 0.5C6.84426 0.5 7.25 0.905742 7.25 1.40625V2.3125H21.75V1.40625C21.75 0.905742 22.1557 0.5 22.6562 0.5C23.1568 0.5 23.5625 0.905742 23.5625 1.40625V2.3125H25.375C27.377 2.3125 29 3.93547 29 5.9375V25.875C29 27.877 27.377 29.5 25.375 29.5H3.625C1.62297 29.5 0 27.877 0 25.875V5.9375C0 3.93547 1.62297 2.3125 3.625 2.3125H5.4375V1.40625C5.4375 0.905742 5.84324 0.5 6.34375 0.5ZM3.625 4.125C2.62398 4.125 1.8125 4.93648 1.8125 5.9375V25.875C1.8125 26.876 2.62398 27.6875 3.625 27.6875H25.375C26.376 27.6875 27.1875 26.876 27.1875 25.875V5.9375C27.1875 4.93648 26.376 4.125 25.375 4.125H3.625Z" fill="#4A4A4A" />
                                    <path d="M4.53125 7.75C4.53125 7.24949 4.93699 6.84375 5.4375 6.84375H23.5625C24.063 6.84375 24.4688 7.24949 24.4688 7.75V9.5625C24.4688 10.063 24.063 10.4688 23.5625 10.4688H5.4375C4.93699 10.4688 4.53125 10.063 4.53125 9.5625V7.75Z" fill="#4A4A4A" />
                                    <path d="M19.9375 14.0938C19.9375 13.5932 20.3432 13.1875 20.8438 13.1875H22.6562C23.1568 13.1875 23.5625 13.5932 23.5625 14.0938V15.9062C23.5625 16.4068 23.1568 16.8125 22.6562 16.8125H20.8438C20.3432 16.8125 19.9375 16.4068 19.9375 15.9062V14.0938Z" fill="#4A4A4A" />
                                    <path d="M14.5 14.0938C14.5 13.5932 14.9057 13.1875 15.4062 13.1875H17.2188C17.7193 13.1875 18.125 13.5932 18.125 14.0938V15.9062C18.125 16.4068 17.7193 16.8125 17.2188 16.8125H15.4062C14.9057 16.8125 14.5 16.4068 14.5 15.9062V14.0938Z" fill="#4A4A4A" />
                                    <path d="M5.4375 19.5312C5.4375 19.0307 5.84324 18.625 6.34375 18.625H8.15625C8.65676 18.625 9.0625 19.0307 9.0625 19.5312V21.3438C9.0625 21.8443 8.65676 22.25 8.15625 22.25H6.34375C5.84324 22.25 5.4375 21.8443 5.4375 21.3438V19.5312Z" fill="#4A4A4A" />
                                    <path d="M10.875 19.5312C10.875 19.0307 11.2807 18.625 11.7812 18.625H13.5938C14.0943 18.625 14.5 19.0307 14.5 19.5312V21.3438C14.5 21.8443 14.0943 22.25 13.5938 22.25H11.7812C11.2807 22.25 10.875 21.8443 10.875 21.3438V19.5312Z" fill="#4A4A4A" />
                                </svg>
                            </span>
                            <span class="menu-text">កាលវិភាគអានសៀវភៅ</span>
                        </a>
                    </li>

                    <li class="menu-item py-1 <?= $controller_group == 'page-template' ? 'has-active' : ''; ?>">
                        <a href="<?= Url::toRoute(['page-template/index']) ?>" class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 27 32" fill="none">
                                    <path d="M5.78571 3.46427H3.85714C1.7269 3.46427 0 5.19117 0 7.32141V27.5714C0 29.7017 1.7269 31.4286 3.85714 31.4286H23.1429C25.2731 31.4286 27 29.7017 27 27.5714V7.32141C27 5.19117 25.2731 3.46427 23.1429 3.46427H21.2143V5.39284H23.1429C24.208 5.39284 25.0714 6.25629 25.0714 7.32141V27.5714C25.0714 28.6365 24.208 29.5 23.1429 29.5H3.85714C2.79202 29.5 1.92857 28.6365 1.92857 27.5714V7.32141C1.92857 6.25629 2.79202 5.39284 3.85714 5.39284H5.78571V3.46427Z" fill="black" />
                                    <path d="M16.3929 2.49998C16.9254 2.49998 17.3571 2.93171 17.3571 3.46427V5.39284C17.3571 5.9254 16.9254 6.35713 16.3929 6.35713H10.6071C10.0746 6.35713 9.64286 5.9254 9.64286 5.39284V3.46427C9.64286 2.93171 10.0746 2.49998 10.6071 2.49998H16.3929ZM10.6071 0.571411C9.00946 0.571411 7.71429 1.86659 7.71429 3.46427V5.39284C7.71429 6.99052 9.00946 8.2857 10.6071 8.2857H16.3929C17.9905 8.2857 19.2857 6.99052 19.2857 5.39284V3.46427C19.2857 1.86659 17.9905 0.571411 16.3929 0.571411H10.6071Z" fill="black" />
                                </svg>
                            </span>
                            <span class="menu-text">របាយការណ៍</span>
                        </a>
                    </li>

                    <li class="menu-item py-1 has-child <?= $controller_group == 'website' ? 'has-active' : ''; ?>">
                        <a href="<?= Url::toRoute(['page-template/index']) ?>" class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 29 28" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8438 2.21875C19.3422 2.21875 18.125 3.43598 18.125 4.9375C18.125 6.43902 19.3422 7.65625 20.8438 7.65625C22.3453 7.65625 23.5625 6.43902 23.5625 4.9375C23.5625 3.43598 22.3453 2.21875 20.8438 2.21875ZM16.4031 4.03125C16.823 1.96297 18.6516 0.40625 20.8438 0.40625C23.0359 0.40625 24.8645 1.96297 25.2844 4.03125H29V5.84375H25.2844C24.8645 7.91203 23.0359 9.46875 20.8438 9.46875C18.6516 9.46875 16.823 7.91203 16.4031 5.84375H0V4.03125H16.4031ZM8.15625 11.2812C6.65473 11.2812 5.4375 12.4985 5.4375 14C5.4375 15.5015 6.65473 16.7188 8.15625 16.7188C9.65777 16.7188 10.875 15.5015 10.875 14C10.875 12.4985 9.65777 11.2812 8.15625 11.2812ZM3.71564 13.0938C4.13548 11.0255 5.96407 9.46875 8.15625 9.46875C10.3484 9.46875 12.177 11.0255 12.5969 13.0938H29V14.9062H12.5969C12.177 16.9745 10.3484 18.5312 8.15625 18.5312C5.96407 18.5312 4.13548 16.9745 3.71564 14.9062H0V13.0938H3.71564ZM20.8438 20.3438C19.3422 20.3438 18.125 21.561 18.125 23.0625C18.125 24.564 19.3422 25.7812 20.8438 25.7812C22.3453 25.7812 23.5625 24.564 23.5625 23.0625C23.5625 21.561 22.3453 20.3438 20.8438 20.3438ZM16.4031 22.1562C16.823 20.088 18.6516 18.5312 20.8438 18.5312C23.0359 18.5312 24.8645 20.088 25.2844 22.1562H29V23.9688H25.2844C24.8645 26.037 23.0359 27.5938 20.8438 27.5938C18.6516 27.5938 16.823 26.037 16.4031 23.9688H0V22.1562H16.4031Z" fill="#4A4A4A" />
                                </svg>
                            </span>
                            <span class="menu-text">ការកំណត់</span>
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
                </ul>
            </nav>
        </div>
    </div>
</aside>