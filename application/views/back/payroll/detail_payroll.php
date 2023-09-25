<style>
    .salary-slip {
        margin: 15px;
    }

    .empDetail {
        width: 100%;
        text-align: left;
        border: 2px solid black;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .head {
        margin: 10px;
        margin-bottom: 50px;
        width: 100%;
    }

    .companyName {
        padding-right: 10px;
        text-align: right;
        font-size: 25px;
        font-weight: bold;
    }

    .slip {
        font-size: 18px;
    }

    .salaryMonth {
        text-align: center;
    }

    .bordered {
        border: 1px solid black;
    }

    .table-border-bottom {
        border-bottom: 1px solid;
    }

    .table-border-right {
        border-right: 1px solid;
    }

    .myBackground {
        padding-top: 10px;
        text-align: left;
        border: 1px solid black;
        height: 40px;
    }

    .myAlign {
        text-align: right;
        padding-right: 30px;
        border-right: 1px solid black;
    }

    .myTotalBackground {
        padding-top: 10px;
        text-align: left;
        background-color: #EBF1DE;
        border-spacing: 0px;
    }

    .align-4 {
        width: 25%;
        float: left;
    }

    .tail {
        margin-top: 35px;
    }

    .align-2 {
        margin-top: 25px;
        width: 50%;
        float: left;
    }

    .border-center {
        text-align: center;
    }

    .border-center th,
    .border-center td {
        border: 1px solid black;
    }

    .bold {
        font-weight: bolder;
    }

    th,
    td {
        padding-left: 6px;
    }

    .signature {
        float: right;
    }

    .signature div {
        padding-inline: 10px;
        margin-top: 25px;
        text-align: right;
    }

    .signature h3 {
        font-size: 18px;
    }
</style>
<!-- detail User Modal -->
<div class="modal fade" id="modal-detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-simple modal-detail-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2 modal-detail-title">Detail Payroll </h3>
                    <!--<p class="text-muted">Updating user details will receive a privacy audit.</p>-->
                </div>
                <form id="form-detail" class="row g-3" action="" method="POST">
                    <input type="hidden" name="id" value="<?= $payroll['id_payroll'] ?>" />
                    <div class="salary-slip">
                        <table class="empDetail">
                            <tr height="100px" style='background-color: #242745'>
                                <td colspan='4'>
                                    <img height="90px" src='<?= base_url('assets/data/logo/') . $identity['favicon']; ?>' />
                                </td>
                                <td colspan='4' class="companyName" style="color: #fff;">Slip Gaji - <?= $identity['company'] ?></br>
                                    <span class="slip"><?= monthIndo($payroll['month_year']); ?></span>
                                </td>
                            </tr>
                            <tr></tr>
                            <th colspan="2">ID Karyawan:</th>
                            <td><?= $employee['employee_id'] ?></td>
                            </tr>
                            <tr>
                                <th colspan="2">Nama:</th>
                                <td><?= $employee['name'] ?></td>
                            </tr>
                            <tr>
                                <th colspan="2">Status Pegawai:</th>
                                <td><?= $employee['status'] ?></td>
                            </tr>
                            <tr>
                                <th colspan="2">Jabatan:</th>
                                <td><?= $employee['job_designation'] ?></td>
                            </tr>
                            <tr>
                                <th colspan="2">Tanggal Masuk:</th>
                                <td><?= dateIndo($employee['date_of_join']) ?></td>
                            </tr>

                            <tr class="myBackground">
                                <th colspan="2">
                                    Pendapatan
                                </th>
                                <th></th>
                                <th class="table-border-right border-center">
                                    Nominal (Rp)
                                </th>
                                <th colspan="2">
                                    Potongan
                                </th>
                                <th></th>
                                <th class="border-center">
                                    Nominal (Rp)
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    Gaji Pokok
                                </th>
                                <td></td>
                                <td class="myAlign">
                                    <?= number_format($employee['basic_salary'], 0, ",", ".") ?>
                                </td>
                                <th colspan="2">
                                    NWNP (No Work No Pay)
                                </th>
                                <td></td>

                                <td class="myAlign">
                                    <?= number_format($payroll['NWNP_pay'], 0, ",", ".") ?>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    Tunjangan Tetap
                                </th>
                                <td></td>

                                <td class="myAlign">
                                    <?= number_format($employee['allowance'], 0, ",", ".") ?>
                                </td>
                                <th colspan="2">
                                    BPJS
                                </th>
                                <td></td>

                                <td class="myAlign">
                                    <?= number_format($payroll['BPJS_pay'], 0, ",", ".") ?>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    Insentif
                                </th>
                                <td></td>

                                <td class="myAlign">
                                    <?= number_format($payroll['incentive'], 0, ",", ".") ?>
                                </td>
                                <th colspan="2"></th>
                                <td></td>
                                <td class="myAlign"></td>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    Upah Lembur
                                </th>
                                <td></td>
                                <td class="myAlign">
                                    <?= number_format($payroll['overtime_pay'], 0, ",", ".") ?>
                                </td>
                                <th colspan="2"></th>
                                <td></td>
                                <td class="myAlign"></td>
                            </tr>

                            <tr class="myBackground">
                                <th colspan="3">
                                    Total Pendapatan
                                </th>
                                <td class="myAlign">
                                    <?= number_format($employee['basic_salary'] + $employee['allowance'] + $payroll['incentive'] + $payroll['overtime_pay'], 0, ",", ".") ?>
                                </td>
                                <th colspan="3">
                                    Total Potongan
                                </th>
                                <td class="myAlign">
                                    <?= number_format($payroll['NWNP_pay'] + $payroll['BPJS_pay'], 0, ",", ".") ?>
                                </td>
                            </tr>
                            <tr height="40px">
                                <th class="border-center bordered">
                                    Hadir / Absen
                                </th>
                                <th class="border-center bordered">
                                    Hari efektif kerja
                                </th>
                                <th class="border-center bordered">
                                    Hari masuk
                                </th class="border-center bordered">
                                <th class="table-border-right border-center bordered">
                                    Hari tidak masuk
                                </th>
                                <th class="table-border-bottom">
                                    Total Gaji
                                </th>
                                <td colspan="3" class="myAlign bold">
                                    <?= number_format($payroll['total_salary'], 0, ",", ".") ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="table-border-right"></td>
                                <td colspan="2" class="table-border-bottom bold">Pembulatan Gaji</td>
                                <td colspan="2" class="myAlign bold">
                                    <?= number_format(round($payroll['total_salary'], -3), 0, ",", ".") ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="table-border-right"></td>
                                <th colspan="2">
                                    Terbilang
                                </th>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <th class="border-center bordered">Bulan ini</th>
                                <td class="border-center bordered"><?= $payroll['workdays'] + $payroll['nwnp'] ?></td>
                                <td class="border-center bordered"><?= $payroll['workdays'] ?></td>
                                <td class="table-border-right border-center bordered"><?= $payroll['nwnp'] ?></td>
                                <td colspan="4">
                                    <?= ucwords(terbilangUang(round($payroll['total_salary'], -3))) . "Rupiah"; ?>
                                </td>
                            </tr>
                        </table>
                        <?php if ($payroll['is_verified']) { ?>
                            <div class="signature" style="position: relative">
                                <div>
                                    <h3>Telah Disahkan</h3>
                                    <br>
                                    <br>
                                    <img style="width: 150px;position: absolute;left: 10px;top: 30px;" src="<?= base_url('assets/data/icons/approved.png') ?>">
                                    <br>
                                    <br>
                                    <h3>Supervisor</h3>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="col-12 text-center">
                        <?php if ((get_sess_data('role_user') == "supervisor" || get_sess_data('role_user') == "admin") && !$payroll['is_verified']) { ?>
                            <button type="submit" id="btnUpdate" class="btn btn-primary me-sm-3 me-1">Sahkan</button>
                        <?php } ?>
                        <button type="reset" id="btnCancel" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Tutup
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ detail User Modal -->

<script>
    $("#form-detail").on('submit', function(e) {
        $('#btnUpdate').html('<span class="spinner-border me-1"></span> Menyimpan...').attr('disabled', true);
        $('#btnCancel').attr('disabled', true);
        e.preventDefault();
        const formData = new FormData(document.getElementById("form-detail"));

        Swal.fire({
            title: "Sahkan payroll",
            text: "Apakah Anda yakin ingin mengesahkan payroll ini?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Sahkan!",
            reverseButtons: true,
            showLoaderOnConfirm: true,
            didOpen: function() {
                $(".swal2-deny").remove();
            },
            preConfirm: function() {
                return new Promise(function(resolve, reject) {
                    setTimeout(function() {
                        $.ajax({
                            url: "payroll/verify_payroll",
                            type: "POST",
                            data: formData,
                            dataType: "JSON",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                if (data.status) {
                                    Swal.fire({
                                        title: "Berhasil..!!!",
                                        text: "Data payroll berhasil disahkan",
                                        icon: "success",
                                        timer: 1000,
                                        showConfirmButton: false,
                                    });
                                    $('#modal-detail').modal('hide');
                                } else {
                                    Swal.fire({
                                        title: "Gagal..!!!",
                                        text: data.msg,
                                        icon: "error",
                                        timer: 1000,
                                        showConfirmButton: false,
                                    });
                                }
                                $(".dtr-bs-modal").modal("hide");
                                reload_table();
                                resolve();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log({
                                    errorThrown
                                });
                                reject("Data payroll gagal disahkan..!!!");
                            },
                        });
                    }, 1000);
                });
            },
            allowOutsideClick: false,
        }).then(function(result) {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Berhasil..!!!",
                    text: "Data payroll berhasil disahkan",
                    icon: "success",
                    timer: 1000,
                    showConfirmButton: false,
                });
            }
            $('#btnUpdate').text('Sahkan').attr('disabled', false);
            $('#btnCancel').attr('disabled', false);
        });
    });
</script>