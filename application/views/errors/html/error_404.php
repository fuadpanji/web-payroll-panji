
<!DOCTYPE html>

<?php 
$CI = &get_instance();
if (!isset($CI)) {
    $CI = new CI_Controller();
} 
$CI->load->helper('url'); 

?>

<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?= base_url(); ?>assets/back/"
  data-template="vertical-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Error - Pages | <?= get_general_settings()['application_name']; ?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/libs/typeahead-js/typeahead.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/css/pages/page-misc.css" />
    <!-- Helpers -->
    <script src="<?= base_url(); ?>assets/back/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="<?= base_url(); ?>assets/back/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url(); ?>assets/back/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <!-- Error -->
    <div class="container-xxl container-p-y">
      <div class="misc-wrapper">
        <h2 class="mb-1 mt-4">Page Not Found :(</h2>
        <p class="mb-4 mx-2">Oops! 😖 The requested URL was not found on this server.</p>
        <a href="<?= base_url();?>" class="btn btn-primary mb-4">Back to home</a>
      </div>
    </div>
    <div class="container-fluid misc-bg-wrapper">
      <img
        src="<?= base_url(); ?>assets/back/img/illustrations/bg-shape-image-light.png"
        alt="page-misc-error"
        data-app-light-img="illustrations/bg-shape-image-light.png"
        data-app-dark-img="illustrations/bg-shape-image-dark.png"
      />
    </div>
    <!-- /Error -->

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= base_url(); ?>assets/back/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/node-waves/node-waves.js"></script>

    <script src="<?= base_url(); ?>assets/back/vendor/libs/hammer/hammer.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/i18n/i18n.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="<?= base_url(); ?>assets/back/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?= base_url(); ?>assets/back/js/main.js"></script>

    <!-- Page JS -->
  </body>
</html>
