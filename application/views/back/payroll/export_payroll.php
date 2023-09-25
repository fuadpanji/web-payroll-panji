<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url(); ?>assets/back/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" />
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
            font-size: 16px;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body>
    <!-- BEGIN: Content-->
    <div class="salary-slip">
        <table class="empDetail">
            <tr height="100px" style='background-color: #242745'>
                <td colspan='4'>
                    <img height="90px" src='<?= base_url('assets/data/logo/') . $identity['favicon']; ?>' />
                </td>
                <td colspan='4' class="companyName" style="color: #fff;">Slip Gaji - <?= $identity['company'] ?></br><br>
                    <span class="slip"><?= monthIndo($payroll['month_year']); ?></span>
                </td>
            </tr>
            <tr>
                <th>ID Karyawan</th>
                <td>&emsp;:&emsp;<?= $employee['employee_id'] ?></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>&emsp;:&emsp;<?= $employee['name'] ?></td>
            </tr>
            <tr>
                <th>Status Pegawai</th>
                <td>&emsp;:&emsp;<?= $employee['status'] ?></td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>&emsp;:&emsp;<?= $employee['job_designation'] ?></td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>&emsp;:&emsp;<?= dateIndo($employee['date_of_join']) ?></td>
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
            <tr class="myBackground" height="40px">
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
                <th class="table-border-bottom">Pembulatan Gaji</th>
                <td colspan="3" class="myAlign bold">
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
                <th class="border-center"></th>
                <td class="border-center"></td>
                <td class="border-center"></td>
                <td class="border-center table-border-right"></td>
                <td colspan="4">
                    <?= ucwords(terbilangUang(round($payroll['total_salary'], -3))) . "Rupiah"; ?>
                </td>
            </tr>
            <tr class="myBackground">
                <th class="border-center bordered">Bulan ini</th>
                <td class="border-center bordered"><?= $payroll['workdays'] + $payroll['nwnp'] ?></td>
                <td class="border-center bordered"><?= $payroll['workdays'] ?></td>
                <td class="table-border-right border-center bordered"><?= $payroll['nwnp'] ?></td>
                <td colspan="4"></td>
            </tr>
        </table>
        <div class="signature" style="position: relative">
            <div>
                <h3>Telah Disahkan</h3>
                <img style="width: 150px;position: absolute;left: 10px;top: 30px;" src="<?= base_url('assets/data/icons/approved.png') ?>">
                <h3>Supervisor</h3>
            </div>
        </div>

    </div>

    <!-- END: Content-->
</body>

</html>