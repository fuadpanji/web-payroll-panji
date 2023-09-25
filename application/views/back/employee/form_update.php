<div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Ubah Data Karyawan <?= $employee['name'] ?></h3>
                </div>
                <form id="form-edit" class="row g-3" action="" method="POST">
                    <input type="hidden" name="id" class="form-control" value="<?= $employee['employee_id'] ?>" />
                    <div class="col-md-12 name">
                        <label class="form-label" for="name">Nama Karyawan</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama Karyawan" value="<?= $employee['name'] ?>" />
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-md-6 birth_place">
                        <label class="form-label" for="birth_place">Tempat Lahir</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="birth_place" name="birth_place" class="form-control" placeholder="Masukkan Tempat Lahir Karyawan" value="<?= $employee['birth_place'] ?>" />
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 birth_date">
                        <label class="form-label" for="birth_date">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" class="form-control" value="<?= $employee['birth_date'] ?>" />
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 col-md-12 gender">
                        <label class="form-label" class="form-label" for="gender">Jenis Kelamin</label>
                        <div class="input-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_lk" value="Laki-laki" <?= ($employee['gender'] == "Laki-laki") ? "checked" : ""; ?> />
                                <label class="form-check-label" for="gender_lk">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_pr" value="Perempuan" <?= ($employee['gender'] == "Perempuan") ? "checked" : ""; ?> />
                                <label class="form-check-label" for="gender_pr">Perempuan</label>
                            </div>
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-md-6 job_designation">
                        <label class="form-label" for="job_designation">Jabatan</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="job_designation" name="job_designation" class="form-control" placeholder="Masukkan Jabatan Karyawan" value="<?= $employee['job_designation'] ?>" />
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-md-6 status">
                        <label class="form-label" for="status">Status Karyawan</label>
                        <div class="input-group input-group-merge">
                            <select class="form-select" id="status" name="status">
                                <option value="" selected="" disabled>Pilih Status Karyawan</option>
                                <option value="Tetap" <?= ($employee['status'] == 'Tetap' ? 'selected' : '') ?>>Tetap</option>
                                <option value="Kontrak" <?= ($employee['status'] == 'Kontrak' ? 'selected' : '') ?>>Kontrak</option>
                                <option value="HL" <?= ($employee['status'] == 'HL' ? 'selected' : '') ?>>HL</option>
                            </select>
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 col-md-12 basic_salary">
                        <label class="form-label" for="basic_salary">Gaji Pokok</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="basic_salary" name="basic_salary" maxlength="13" class="form-control" placeholder="Rp. 100.000" value="<?= $employee['basic_salary'] ?>" />
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 col-md-12 allowance">
                        <label class="form-label" for="allowance">Tunjangan</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="allowance" name="allowance" maxlength="13" class="form-control" placeholder="Rp. 100.000" value="<?= $employee['allowance'] ?>" />
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 date_of_join">
                        <label class="form-label" for="date_of_join">Tanggal Masuk</label>
                        <input type="date" id="date_of_join" name="date_of_join" class="form-control" value="<?= $employee['date_of_join'] ?>" />
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6">
                        <label for="has_BPJS" class="form-label">Ikut BPJS</label>
                        <p class="m-2"></p>
                        <label class="switch switch-success">
                            <input type="checkbox" id="has_BPJS" name="has_BPJS" class="switch-input" <?= ($employee['has_BPJS'] == 1) ? "checked" : ""; ?> />
                            <span class="switch-toggle-slider">
                                <span class="switch-on">
                                    <i class="ti ti-check"></i>
                                </span>
                                <span class="switch-off">
                                    <i class="ti ti-x"></i>
                                </span>
                            </span>
                        </label>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" id="btnUpdate" class="btn btn-primary me-sm-3 me-1">Simpan</button>
                        <button type="reset" id="btnCancel" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var salaryElement = document.getElementById("basic_salary"); // On Ready
    salaryElement.value = formatRupiah(salaryElement.value, "Rp. ");

    salaryElement.addEventListener("keyup", function(e) { // If Change
        this.value = formatRupiah(this.value, "Rp. ");
    });

    var alowanceElement = document.getElementById("allowance"); // On Ready
    alowanceElement.value = formatRupiah(alowanceElement.value, "Rp. ");

    alowanceElement.addEventListener("keyup", function(e) { // If Change
        this.value = formatRupiah(this.value, "Rp. ");
    });

    $("#form-edit").on('submit', (function(e) {
        $('#btnUpdate').html('<span class="spinner-border me-1"></span> Menyimpan...').attr('disabled', true);
        $('#btnCancel').attr('disabled', true);
        e.preventDefault();
        const formData = new FormData(document.getElementById("form-edit"));

        $.ajax({
            url: "employee/update_employee",
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
                        if (value != '') {
                            $('.' + key).addClass('is-invalid');
                            $('.' + key).parent('.col-12').find('#form-error').html(value);
                        }
                    });
                    toastr["error"](data.message.text, data.message.title);
                }
                $('#btnUpdate').text('Simpan').attr('disabled', false);
                $('#btnCancel').attr('disabled', false);
            },

            error: function(jqXHR, textStatus, errorThrown) {
                toastr["error"](errorThrown, "Error");
                $('#btnUpdate').text('Simpan').attr('disabled', false);
                $('#btnCancel').attr('disabled', false);
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
    $('#form-edit select, #form-edit input[type=radio]').on('change', function() {
        if ($(this).val() == '') {
            $(this).removeClass('is-valid');
        } else {
            $(this).removeClass('is-invalid');
            $(this).parents('.col-12').find('#form-error').html(" ");
        }
    });
</script>