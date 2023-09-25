<!-- Edit User Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 modal-edit-title">Ubah Informasi User: </h3>
                    <!--<p class="text-muted">Updating user details will receive a privacy audit.</p>-->
                </div>
                <form id="form-edit" class="row g-3" action="" method="POST">
                    <div class="col-12 col-md-6 username">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="john.doe.007" value="<?= $user['username']; ?>" />
                        <input type="hidden" id="id" name="id" value="<?= $user['id_user']; ?>" />
                        <div id="form-error"></div>
                    </div>
                    <div class="col-12 col-md-6 email">
                        <label class="form-label" for="email">Email</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="example@domain.com" value="<?= $user['email']; ?>" />
                        <div id="form-error"></div>
                    </div>
                    <div class="col-12 col-md-6 role">
                        <label class="form-label" for="role">Role</label>
                        <select id="role" name="role" class="form-select">
                            <?php foreach ($roles as $row) { ?>
                                <option value="<?= $row ?>" <?= ($row == $user['role_user']) ? "selected" : ""; ?>><?= strtoupper($row); ?></option>
                            <?php } ?>
                        </select>
                        <div id="form-error"></div>
                    </div>
                    <hr class="mb-0">
                    <div class="col-12 col-md-6 form-password-toggle password">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" class="form-control" id="password" name="password" placeholder="********" />
                            <span class="input-group-text cursor-pointer" id="password2"><i class="ti ti-eye-off"></i></span>
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-12 col-md-6 form-password-toggle confirmPassword">
                        <label class="form-label" for="confirmPassword">Konfirmasi Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="********" />
                            <span class="input-group-text cursor-pointer" id="confirmPassword2"><i class="ti ti-eye-off"></i></span>
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" id="btnUpdate" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->
<script>

    window.Helpers.initPasswordToggle();

    $("#form-edit").on('submit', (function(e) {
        $('#btnUpdate').html('<span class="spinner-border me-1"></span> Menyimpan...').attr('disabled', true);
        e.preventDefault();
        const formData = new FormData(document.getElementById("form-edit"));

        $.ajax({
            url: "users/update_users",
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
                    $('#modal-edit').modal('hide')
                    toastr["success"](data.message.text, data.message.title);
                    reload_table()
                } else {
                    $.each(data, function(key, value) {
                        // console.log(key+": "+value)
                        if (value != '') {
                            $('#' + key).addClass('is-invalid');
                            $('.' + key).find('#form-error').html(value);
                        }
                    });
                    toastr["error"](data.message.text, data.message.title);
                }
                $('#btnUpdate').text('Simpan').attr('disabled', false);
            },

            error: function(jqXHR, textStatus, errorThrown) {
                toastr["error"](errorThrown, "Error");
                $('#btnUpdate').text('Simpan').attr('disabled', false);
            }
        });
    }));

    $('#form-edit input').on('keyup', function() {
        if ($(this).val() == '') {
            $(this).removeClass('is-valid');
        } else {
            $(this).removeClass('is-invalid');
            $(this).parents('.col-12').find('#form-error').html(" ");
        }
    });
    $('#form-edit select, #form-edit input[type=date], #form-edit input[type=radio]').on('change', function() {
        if ($(this).val() == '') {
            $(this).removeClass('is-valid');
        } else {
            $(this).removeClass('is-invalid');
            $(this).parents('.col-12').find('#form-error').html(" ");
        }
    });
</script>