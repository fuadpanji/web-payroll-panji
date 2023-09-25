<div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Ubah Data Waktu Pulang Presensi</h3>
                </div>
                <form id="form-edit" class="row g-3" action="" method="POST">
                    <input type="hidden" name="id" class="form-control" value="<?= $attendance['id_attendance'] ?>" />
                    <div class="col-lg-12 signout_time">
                        <label class="form-label" for="signout_time">Waktu Pulang</label>
                        <input type="time" id="signout_time" name="signout_time" class="form-control" placeholder="Waktu Pulang" />
                        <div id="form-error"></div>
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
    $("#signout_time").flatpickr({
        enableTime: true,
        noCalendar: true,
        onChange: (selectedDates, dateStr, instance) => {
            $(".signout_time>.is-invalid").removeClass("is-invalid");
            $(".signout_time").find("#form-error").html("");
        },
    });

    $("#form-edit").on('submit', (function(e) {
        $('#btnUpdate').html('<span class="spinner-border me-1"></span> Menyimpan...').attr('disabled', true);
        $('#btnCancel').attr('disabled', true);
        e.preventDefault();
        const formData = new FormData(document.getElementById("form-edit"));

        $.ajax({
            url: "attendance/update_attendance",
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
    
</script>