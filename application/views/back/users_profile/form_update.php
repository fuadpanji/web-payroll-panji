<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manajemen Pengguna / </span> Profile</h4>
<div class="row">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-0 order-md-0">
        <!-- User Card -->
        <div class="card mb-4">
            <div class="card-body">
                <p class="small text-uppercase text-muted">Detail</p>
                <div class="info-container">
                    <ul class="list-unstyled">

                        <li class="mb-2">
                            <span class="fw-semibold me-1">Username:</span>
                            <span><?= ($user['username'] != "") ? $user['username'] : "-";; ?></span>
                            <span id="id" class="d-none"><?= $user['id_user']; ?></span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span class="fw-semibold me-1">Email:</span>
                            <span><?= $user['email']; ?></span>
                        </li>
                        <li class="mb-2 pt-1">
                            <span class="fw-semibold me-1">Role:</span>
                            <span><?= strtoupper($user['role_user']); ?></span>
                        </li>
                </div>
            </div>
        </div>
        <!-- /User Card -->
    </div>
    <!--/ User Sidebar -->

    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-1 order-md-1">

        <!-- Change Password -->
        <?php if($user['id_user'] == get_sess_data('id_user')) { ?>
        <div class="card mb-4">
            <h5 class="card-header">Ubah Password</h5>
            <div class="card-body">
                <form id="formAccountSettings" method="POST">
                    <div class="row">
                        <div class="mb-3 col-md-6 form-password-toggle">
                            <label class="form-label" for="currentPassword">Password Sekarang</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" name="currentPassword" id="currentPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <input type="hidden" class="form-control" name="id" value="<?= $user['id_user'] ?>" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            <div id="form-error"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6 form-password-toggle">
                            <label class="form-label" for="newPassword">Password Baru</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            <div id="form-error"></div>
                        </div>

                        <div class="mb-3 col-md-6 form-password-toggle">
                            <label class="form-label" for="confirmPassword">Konfirmasi Password Baru</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            <div id="form-error"></div>
                        </div>
                        <!--<div class="col-12 mb-4">-->
                        <!--    <h6>Password Requirements:</h6>-->
                        <!--    <ul class="ps-3 mb-0">-->
                        <!--        <li class="mb-1">Minimal panjang 8 karakter - lebih panjang, lebih baik</li>-->
                        <!--        <li class="mb-1">Mengandung setidaknya 1 huruf kecil dan 1 huruf besar</li>-->
                        <!--        <li>Mengandung setidaknya 1 angka dan 1 simbol</li>-->
                        <!--    </ul>-->
                        <!--</div>-->
                        <div>
                            <button type="submit" id="btnChangePassword" class="btn btn-primary me-2">Simpan</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php } ?>
        <!--/ Change Password -->
    </div>
    <!--/ User Content -->
</div>

<script>

    function changePassword() {
        $('#btnChangePassword').html('<span class="spinner-border me-1"></span> Menyimpan...').attr('disabled', true);
        const formData = new FormData(document.getElementById("formAccountSettings"));

        $.ajax({
            url: "<?php echo base_url(); ?>back/users/update_password",
            type: "POST",
            data: formData,
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $("#err").fadeOut();
            },

            success: function(data) {
                if (data.status) {
                    toastr["success"](data.message.text, data.message.title);
                    $('#formAccountSettings')[0].reset();
                } else {
                    $.each(data, function(key, value) {
                        // console.log(key+": "+value)
                        if (value != '') {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parent('.mb-3').find('#form-error').html(value);
                        }
                    });
                    toastr["error"](data.message.text, data.message.title);
                }
                $('#btnChangePassword').text('Simpan').attr('disabled', false);
            },

            error: function(jqXHR, textStatus, errorThrown) {
                toastr["error"](errorThrown, "Error");
                $('#btnChangePassword').text('Simpan').attr('disabled', false);
            }
        });

        $('#formAccountSettings input').on('keyup', function() {
            if ($(this).val() == '') {
                $(this).removeClass('is-valid');
            } else {
                $(this).removeClass('is-invalid');
                $(this).parents('.mb-3').find('#form-error').html(" ");
            }
        });
    }
</script>
<!-- /Modals -->