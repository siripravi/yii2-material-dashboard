<?php
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
$this->beginPage();
?>
<!--
=========================================================
 Yii2 Framework Material Dashboard - v1.0.0
=========================================================

 Product Page: https://www.coderseden.com/product/material-dashboard-yii2
 Copyright 2020 CodersEden (https://www.coderseden.com)
 Licensed under MIT (https://opensource.org/licenses/MIT)

 Developed by CodersEden

 =========================================================
 Material Dashboard - v2.1.2
 =========================================================

 Product Page: https://www.creative-tim.com/product/material-dashboard
 Copyright 2020 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/material-dashboard/blob/master/LICENSE.md)

 Coded by Creative Tim

 =========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Extra details for Demo -->
  <link rel="apple-touch-icon-precomposed" sizes="57x57"
    href="<?= \Yii::getAlias('@web/img/favicon/apple-touch-icon-57x57.png'); ?>" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114"
    href="<?= \Yii::getAlias('@web/img/favicon/apple-touch-icon-114x114.png'); ?>" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72"
    href="<?= \Yii::getAlias('@web/img/favicon/apple-touch-icon-72x72.png'); ?>" />
  <link rel="apple-touch-icon-precomposed" sizes="144x144"
    href="<?= \Yii::getAlias('@web/img/favicon/apple-touch-icon-144x144.png'); ?>" />
  <link rel="apple-touch-icon-precomposed" sizes="60x60"
    href="<?= \Yii::getAlias('@web/img/favicon/apple-touch-icon-60x60.png'); ?>" />
  <link rel="apple-touch-icon-precomposed" sizes="120x120"
    href="<?= \Yii::getAlias('@web/img/favicon/apple-touch-icon-120x120.png'); ?>" />
  <link rel="apple-touch-icon-precomposed" sizes="76x76"
    href="<?= \Yii::getAlias('@web/img/favicon/apple-touch-icon-76x76.png'); ?>" />
  <link rel="apple-touch-icon-precomposed" sizes="152x152"
    href="<?= \Yii::getAlias('@web/img/favicon/apple-touch-icon-152x152.png'); ?>" />
  <link rel="icon" type="image/png" href="<?= \Yii::getAlias('@web/img/favicon/favicon-196x196.png'); ?>"
    sizes="196x196" />
  <link rel="icon" type="image/png" href="<?= \Yii::getAlias('@web/img/favicon/favicon-96x96.png'); ?>" sizes="96x96" />
  <link rel="icon" type="image/png" href="<?= \Yii::getAlias('@web/img/favicon/favicon-32x32.png'); ?>" sizes="32x32" />
  <link rel="icon" type="image/png" href="<?= \Yii::getAlias('@web/img/favicon/favicon-16x16.png'); ?>" sizes="16x16" />
  <link rel="icon" type="image/png" href="<?= \Yii::getAlias('@web/img/favicon/favicon-128.png'); ?>" sizes="128x128" />
  <meta name="msapplication-TileColor" content="#FFFFFF" />
  <meta name="msapplication-TileImage" content="<?= \Yii::getAlias('@web/img/favicon/mstile-144x144.png'); ?>" />
  <meta name="msapplication-square70x70logo" content="<?= \Yii::getAlias('@web/img/favicon/mstile-70x70.png'); ?>" />
  <meta name="msapplication-square150x150logo" content="<?= \Yii::getAlias('@web/img/favicon/mstile-150x150.png'); ?>" />
  <meta name="msapplication-wide310x150logo" content="<?= \Yii::getAlias('@web/img/favicon/mstile-310x150.png'); ?>" />
  <meta name="msapplication-square310x310logo" content="<?= \Yii::getAlias('@web/img/favicon/mstile-310x310.png'); ?>" />
  <meta name="author" content="CodersEden.com" />
  <meta name="theme-color" content="#ffffff">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="<?= \Yii::getAlias('@web/css/material-dashboard.css?v=3.1.0'); ?>" rel="stylesheet" />
  <link href="<?= \Yii::getAlias('@web/css/main.css'); ?>" rel="stylesheet" />
  <?= Html::csrfMetaTags() ?>
  <title>Material Dashboard Yii2 - Free Frontend Preset for Yii2 Framework</title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="<?= \Yii::getAlias('@web/css/nucleo-icons.css');?>" rel="stylesheet" />
  <link href="<?= \Yii::getAlias('@web/css/nucleo-svg.css');?>" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <?php $this->head() ?>
</head>

<body class="g-sidenav-show  bg-gray-200">
  <!-- Extra Body details for Demo -->
  <?php $this->beginBody() ?>

  <?= $this->render(
    'left.php'
  )
    ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?= $this->render(
      'header.php'
    )
      ?>

    <?= $this->render(
      'content.php',
      ['content' => $content]
    ) ?>

    <?= $this->render(
      'footer.php'
    )
      ?>
  </main>

  <?= $this->render(
    'plugin.php'
  )
    ?>
  <!--   Core JS Files   -->
  <!--   Core JS Files   -->

  <script src='<?= \Yii::getAlias("@web/js/core/popper.min.js"); ?>'></script>
  <script src='<?= \Yii::getAlias("@web/js/core/bootstrap.min.js"); ?>'></script>
  <script src='<?= \Yii::getAlias("@web/js/plugins/perfect-scrollbar.min.js"); ?>'></script>
  <script src='<?= \Yii::getAlias("@web/js/plugins/smooth-scrollbar.min.js"); ?>'></script>
  <script src='<?= \Yii::getAlias("@web/js/plugins/chartjs.min.js"); ?>'></script>
  <script src="<?= \Yii::getAlias('@web/js/core/jquery.min.js'); ?>"></script>


  <script>
    $(document).ready(function () {
      // Javascript method's body can be found in assets/js/demos.js
     // md.initDashboardPageCharts();

    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
 
  <!-- Github buttons -->
  <!--<script async defer src="https://buttons.github.io/buttons.js"></script>  -->
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?= \Yii::getAlias('@web/js/material-dashboard.min.js'); ?>" type="text/javascript"></script>
  <script>
			$('#modalButton').click(function () {
				$('#objectModal').modal('show');
				$.pjax.reload('#pjax-container');
			});
		</script>
  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>