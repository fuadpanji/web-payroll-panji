<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url(); ?>assets/back/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="keywords" content="<?= $identity['keyword_site'] ?>" />
    <meta name="description" content="<?= $identity['description_site'] ?>" />
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

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="javascript:void(0)" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-body fw-bold ms-1">
                                    <img class="icon" style="width: 250px;" src="<?= base_url('assets/data/logo/' . $identity['logo_red']); ?>" data-app-light-img="<?= base_url('assets/data/logo/' . $identity['logo_red']); ?>" data-app-dark-img="<?= base_url('assets/data/logo/' . $identity['logo_white']); ?>" alt="">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">Lupa Password? 🔒</h4>
                        <p class="mb-4">Masukkan email anda dan kami akan kirim instruksi untuk mengatur ulang password anda.</p>
                        <form id="formAuthentication" class="mb-3" action="" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan email anda" autofocus />
                            </div>

                            <?php if ($recaptcha_status) : ?>
                                <div class="d-flex justify-content-center align-items-center my-4">
                                    <?php generate_recaptcha(); ?>
                                </div>
                            <?php endif; ?>
                            <button class="btn btn-primary w-100" type="submit" id="btnReset">Kirim</button>
                        </form>
                        <div class="text-center">
                            <a href="/auth" class="d-flex align-items-center justify-content-center">
                                <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                                Kembali ke Login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>

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
    <script src="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <script src="<?= base_url(); ?>assets/back/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- Main JS -->
    <script src="<?= base_url(); ?>assets/back/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?= base_url(); ?>assets/back/js/pages-auth.js"></script>
    <script>
        function submitForm() {
            $('#btnReset').html('<span class="spinner-border me-1"></span> Memproses...').attr('disabled', true);
            let url = "<?php echo site_url('auth/postForgotPassword') ?>";
            const formData = new FormData(document.getElementById("formAuthentication"));
            // formData.append('isActive', document.getElementById("status").checked)

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
                            text: "Aksi Anda tidak diizinkan. Harap refresh halaman dan ulangi kembali",
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

                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });

                        Swal.fire({
                            title: res.message.title,
                            text: res.message.text.replace(/<p[^>]*>/g, '').replace(/<\/p>/g, ''),
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then(function() {
                            window.location.href = "/auth";
                        });

                        <?php if ($recaptcha_status) { ?>
                            grecaptcha.reset();
                        <?php } ?>
                    } else {
                        $(".alert").addClass("d-none");
                        <?php if ($recaptcha_status) { ?>
                            grecaptcha.reset();
                        <?php } ?>
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
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
                    }

                    $('#btnReset').text('Kirim Reset Link').attr('disabled', false);

                },

                error: function(jqXHR, textStatus, errorThrown) {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });

                    Swal.fire({
                        title: "Reset Password Gagal!",
                        text: errorThrown,
                        icon: 'error',
                        timer: 3000,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    })
                    $('#btnReset').text('Kirim Reset Link').attr('disabled', false);

                }
            });
        }
    </script>
</body>

</html>