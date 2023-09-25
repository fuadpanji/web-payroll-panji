<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url(); ?>assets/back/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $title ?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/data/logo/') . $identity['favicon']; ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

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
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/libs/toastr/toastr.css" />
    <?= (isset($comp_css)) ? $comp_css : ""; ?>

    <!-- Page CSS -->
    <!-- Helpers -->
    <script src="<?= base_url(); ?>assets/back/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="<?= base_url(); ?>assets/back/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url(); ?>assets/back/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="javascript:void(0)" class="app-brand-link">
                        <span class="app-brand-text demo menu-text fw-bold">
                            <img class="icon" style="width: 185px;" src="<?= base_url('assets/data/logo/' . $identity['sidebar']); ?>" alt="Logo">
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                    <li class="menu-item <?= ($this->uri->segment(2) == "dashboard") ? "active" : ""; ?>">
                        <a href="/back/dashboard" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-smart-home"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>


                    <!-- Layanan -->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Manajemen Karyawan</span>
                    </li>
                    <?php if (is_admin()) : ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "employee") ? "active open" : ""; ?>">
                            <a href="/back/employee" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-users"></i>
                                <div>Data Karyawan</div>
                            </a>
                        </li>
                        <li class="menu-item <?= ($this->uri->segment(2) == "attendance") ? "active open" : ""; ?>">
                            <a href="/back/attendance" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-clock"></i>
                                <div>Presensi Karyawan</div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="menu-item <?= ($this->uri->segment(2) == "payroll") ? "active open" : ""; ?>">
                        <a href="/back/payroll" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-file-text"></i>
                            <div>Payroll Karyawan</div>
                        </a>
                    </li>
                    <?php if (is_admin()) : ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "settings") ? "active" : ""; ?>">
                            <a href="/back/settings" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-settings"></i>
                                <div>Pengaturan</div>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="ti ti-menu-2 ti-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center d-none">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                                    <i class="ti ti-search ti-md me-2"></i>
                                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                                </a>
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- Style Switcher -->
                            <li class="nav-item me-2 me-xl-0">
                                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                                    <i class="ti ti-md"></i>
                                </a>
                            </li>
                            <!--/ Style Switcher -->

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown ms-1">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <?php $stateNum = rand(0, 5);
                                        $states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'];
                                        $state = $states[$stateNum];
                                        $initials = (!empty(user_data(get_sess_data('id_user'))['username'])) ? get_initials(user_data(get_sess_data('id_user'))['username']) : get_initials("User");
                                        $result = '<span class="avatar-initial rounded-circle bg-label-' . $state . '">' . $initials . '</span>';
                                        echo $result;
                                        ?>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <?php $stateNum = rand(0, 5);
                                                        $states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'];
                                                        $state = $states[$stateNum];
                                                        $initials = (!empty(user_data(get_sess_data('id_user'))['username'])) ? get_initials(user_data(get_sess_data('id_user'))['username']) : get_initials("User");
                                                        $result = '<span class="avatar-initial rounded-circle bg-label-' . $state . '">' . $initials . '</span>';
                                                        echo $result; ?>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block"><?= user_data(get_sess_data('id_user'))['username'] ?></span>
                                                    <small class="text-muted"><?= user_data(get_sess_data('id_user'))['role_user'] ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="profile">
                                            <i class="ti ti-user-check me-2 ti-sm"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item btn btn-label-danger" href="/auth/logout">
                                            <i class="ti ti-logout me-2 ti-sm"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper d-none">
                        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search..." />
                        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?= $contents; ?>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div class="footer-container d-flex align-items-center justify-content-between mt-4 flex-md-row flex-column">
                                <div>© <?= $identity['company'] ?></div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= base_url(); ?>assets/back/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/node-waves/node-waves.js"></script>

    <script src="<?= base_url(); ?>assets/back/vendor/libs/hammer/hammer.js"></script>
    <!--<script src="<?= base_url(); ?>assets/back/vendor/libs/i18n/i18n.js"></script>-->
    <script src="<?= base_url(); ?>assets/back/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="<?= base_url(); ?>assets/back/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/toastr/toastr.js"></script>

    <?= (isset($vendor_js)) ? $vendor_js : ""; ?>

    <!-- Main JS -->
    <script src="<?= base_url(); ?>assets/back/js/main.js"></script>

    <!-- Page JS -->
    <?= (isset($page_js)) ? $page_js : ""; ?>

    <script>
        var url = '<?= $this->uri->segment(2); ?>';
        // console.log(url)
        if (url == "dashboard") {
            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }

            function eraseCookie(name) {
                document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            }

            let welcome_login = getCookie('welcome_login');
            if (welcome_login == "true") {
                toastr["success"]("Selamat datang kembali", `Halo, ${'<?= ucwords($this->session->userdata('username')) ?>'}!`);
                eraseCookie('welcome_login');
            }
        }
    </script>
</body>

</html>