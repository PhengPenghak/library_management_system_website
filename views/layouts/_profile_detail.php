<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\BreadcrumbsEKV;
use app\assets\AppAsset;
use app\assets\SweetAlert2Asset;
use app\widgets\Breadcrumbs;
use yii\helpers\Url;

$formater = Yii::$app->formater;
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$controller_action = $controller . '-' . $action;

AppAsset::register($this);
SweetAlert2Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
  <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/img/fav.png" />
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
  <style>
    .page-cover {
      min-height: 13rem;
    }

    .vendorProfile {
      width: 180px;
      height: 150px;
      object-fit: cover;
      border-radius: 5px;
    }
  </style>
</head>

<body>
  <?php $this->beginBody() ?>

  <div class="app">

    <?= $this->render('_header'); ?>
    <?= $this->render('_aside'); ?>

    <main class="app-main">
      <div class="wrapper">
        <div class="page">
          <?= $this->render('//site/modal_scrollable'); ?>
          <header class="page-cover">
            <div class="cover-controls cover-controls-top">
            </div>
            <div class="row align-items-center">
              <div class="col-lg-3 offset-lg-2">
                <div class="text-center">
                  <img class="vendorProfile shadow" src="<?= Yii::getAlias("@web/img/logo-placeholder.jpg") ?>" alt="">
                </div>
              </div>
              <div class="col-lg-5">
                <h2 class="h4 mt-2 mb-0"></h2>
                <div class="my-1">
                  <i class="fa fa-star text-yellow"></i> <i class="fa fa-star text-yellow"></i> <i class="fa fa-star text-yellow"></i> <i class="fa fa-star text-yellow"></i> <i class="far fa-star text-yellow"></i>
                </div>
                <p class="text-muted">#, joined at </p>
                <p><i class="bi bi-geo-alt-fill"></i></p>
              </div>
            </div>
          </header>
          <nav class="page-navs">
            <!-- .nav-scroller -->
            <div class="nav-scroller">
              <!-- .nav -->
              <div class="nav nav-center nav-tabs">
                <a class="nav-link <?= $controller_action === 'vendors-facility' ? 'active' : '' ?>" href="<?= Url::toRoute(['vendors/facility', 'id' => $master->vendorID]) ?>">Facility</a>
                <!-- <a class="nav-link" href="user-activities.html">Activities</a> -->
                <a class="nav-link <?= $controller_action === 'vendors-profile' ? 'active' : '' ?>" href="<?= Url::toRoute(['vendors/profile', 'id' => $master->vendorID]) ?>">Profile</a>
                <a class="nav-link <?= $controller_action === 'vendors-room_type' ? 'active' : '' ?>" href="<?= Url::toRoute(['vendors/room-type']) ?>">Room Type</a>
                <a class="nav-link <?= $controller_action === 'vendors-room_type' ? 'active' : '' ?>" href="<?= Url::toRoute(['report/index']) ?>">Gallery</a>
                <a class="nav-link <?= $controller_action === 'vendor-setting' ? 'active' : '' ?>" href="<?= Url::toRoute(['vendor/setting']) ?>">Settings</a>
              </div><!-- /.nav -->
            </div><!-- /.nav-scroller -->
          </nav>
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

  $(document).on("click", "#buttonChangeVendor", function() {
    $("#modalScrollable").modal("show")
      .find("#modalContent")
      .load($(this).attr("value"));
    $("#modalScrollable").find("#modalScrollableLabel").text($(this).data("title"));
  });

  $('#modalScrollable').on('hidden.bs.modal', function(e) {
    $("#modalContent").html("");
  });

  // $('.dropdown-toggle').dropdown();
</script>
<?php $this->endPage() ?>