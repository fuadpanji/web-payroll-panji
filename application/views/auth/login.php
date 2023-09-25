<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url(); ?>assets/back/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="author" content="<?= $identity['company'] ?>" />
    <meta property="og:locale" content="en-US" />
    <meta property="og:site_name" content="<?= $identity['company'] ?>" />
    <meta property="og:image:width" content="160" />
    <meta property="og:image:height" content="60" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= $title ?>" />
    <meta property="og:url" content="<?= current_url() ?>" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/data/logo/') . $identity['favicon']; ?>" title="Favicon" />


    <title><?= $title ?></title>

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
    <!-- Vendor -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/libs/sweetalert2/sweetalert2.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/back/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="<?= base_url(); ?>assets/back/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="<?= base_url(); ?>assets/back/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url(); ?>assets/back/js/config.js"></script>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="overflow-hidden">
    <!-- BEGIN: Content-->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4" style="max-width: 550px">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="javascript:void(0)" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-body fw-bold ms-1">
                                    <img class="icon" style="width: 250px;" src="<?= base_url('assets/data/logo/' . $identity['sidebar']); ?>" data-app-light-img="<?= base_url('assets/data/logo/' . $identity['sidebar']); ?>" data-app-dark-img="<?= base_url('assets/data/logo/' . $identity['sidebar']); ?>" alt="">
                                </span>
                                <!--<span class="app-brand-text demo text-body fw-bold ms-1">Vuexy</span>-->
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">Selamat Datang!</h4>
                        <p class="mb-4">Silahkan login ke akun Anda untuk melanjutkan</p>
                        <div id="checking" class="alert alert-warning d-none text-center" role="alert"></div>
                        <div id="success" class="alert alert-success d-none d-flex align-items-center" role="alert">
                            <span class="alert-icon text-success me-2">
                                <i class="ti ti-check ti-xs"></i>
                            </span>
                            <span id="success-message"></span>
                        </div>

                        <form id="formAuthentication" class="mb-3" action="index.html" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email atau Username</label>
                                <input type="text" class="form-control" id="email" name="email-username" placeholder="Masukkan email atau username anda" autofocus />
                                <input type="hidden" class="csrf_security" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                    <input type="hidden" id="status_reset" name="status_reset" value="<?= $this->session->userdata('status_reset'); ?>" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Ingat Saya </label>
                                </div>
                                <a href="javascript:void(0)">
                                    <small>Lupa Password?</small>
                                </a>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary w-100" id="btnLogin" type="submit">Login</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

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
    <script src="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- Main JS -->
    <script src="<?= base_url(); ?>assets/back/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?= base_url(); ?>assets/back/js/pages/login.js"></script>
    <script>
        $(document).ready(function() {
            let status_reset = $("#status_reset").val();
            if (status_reset == 1) {
                Swal.fire({
                    title: "<?= $this->session->userdata('icon_reset') ?>",
                    text: "<?= $this->session->userdata('message_reset') ?>",
                    icon: '<?= $this->session->userdata('icon_reset') ?>',
                    timer: 3000,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
                <?= $this->session->unset_userdata('status_reset');
                $this->session->unset_userdata('message_reset');
                $this->session->unset_userdata('icon_reset'); ?>
            }
        });

        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function submitForm() {
            $('#btnLogin').html('<span class="spinner-border me-1"></span> Memeriksa...').attr('disabled', true);
            $("#checking").removeClass("d-none").text("Memeriksa...");
            let url = "<?php echo site_url('auth/postLogin') ?>";
            const formData = new FormData(document.getElementById("formAuthentication"));

            $.ajax({
                statusCode: {
                    500: function() {
                        Swal.fire({
                            title: res.message.title,
                            text: "Internal Server Error. Harap coba beberapa saat lagi",
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        })
                    },
                    403: function() {
                        Swal.fire({
                            title: res.message.title,
                            text: "Aksi Anda tidak diizinkan. Harap refresh halaman dan login kembali",
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        })
                    }
                },
                url: url,
                type: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#err").fadeOut();
                },

                success: function(res) {
                    $(".csrf_security").val(res.token);
                    if (res.status) {
                        $('#btnLogin').text('Redirect...')
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        $("#checking").addClass("d-none");
                        $("#success").removeClass("d-none").find("#success-message").text(res.message.title + res.message.text);
                        setCookie('welcome_login', true, 1);
                        setTimeout(function() {
                            window.location.href = res.url;
                        }, 1500);

                    } else {
                        $("#checking").addClass("d-none");
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        $.each(res, function(key, value) {
                            // console.log(key+": "+value)
                            if (value != '') {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parent('.mb-3').find('#form-error').html(value);
                            }
                        });

                        Swal.fire({
                            title: res.message.title,
                            text: res.message.text.replace(/<p[^>]*>/g, '').replace(/<\/p>/g, ''),
                            icon: 'error',
                            timer: 3000,
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        })
                        $('#btnLogin').text('Login').attr('disabled', false);
                    }

                },

                error: function(jqXHR, textStatus, errorThrown) {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });

                    Swal.fire({
                        title: "Login Gagal!",
                        text: errorThrown,
                        icon: 'error',
                        timer: 3000,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    })
                    $('#btnLogin').text('Login').attr('disabled', false);

                }
            });
        }
    </script>
</body>

</html>