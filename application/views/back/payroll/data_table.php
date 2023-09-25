<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Data Payroll </h4>

<!-- DataTable with Buttons -->
<div class="card">
    <div class="row p-5">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="payroll" method="POST">
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Karyawan</label>
                                <select class="form-control select2 form-select" name="empId">
                                    <option value="semua" <?= ($empId == 'semua') ? 'selected' : ''; ?>>
                                        Semua Karyawan
                                    </option>
                                    <?php foreach ($employees as $employee) { ?>
                                        <option value="<?= $employee['employee_id'] ?>" <?= ($empId == $employee['employee_id']) ? 'selected' : ''; ?>>
                                            <?= $employee['name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label>Tanggal</label>
                                <div class="input-group">
                                    <input type="month" class="form-control pull-right" name="monthYear" value="<?= isset($my) ? $my : '' ?>" max="<?= date('Y-m'); ?>" placeholder="Pilih tanggal" id="monthYear">
                                </div>
                            </div>
                            <div class="col-lg-1" style="margin-top:18px; padding:5px">
                                <button type="submit" class="btn btn-block btn-success"><i class="fa fa-search me-2"></i> Cari</button>
                            </div>
                            <div class="col-lg-1"></div>
                            <?php if ($rows < 1 && (get_sess_data('role_user') == "staff" || get_sess_data('role_user') == "admin")) { ?>
                                <div class="col-lg-2" style="margin-top:18px; padding:5px">
                                    <button onclick="generate_payroll()" class="btn btn-block btn-primary btn-generate"><i class="fa fa-refresh me-2"></i> Generate Payroll</button>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
                <?php if ($rows < 1 && (get_sess_data('role_user') == "staff" || get_sess_data('role_user') == "admin")) { ?>
                <div class="d-flex justify-content-center pt-3">
                    <span class="text-primary">* Tombol Generate Payroll akan mengenerate untuk semua karyawan</span>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table">
            <thead>
                <tr>
                    <th></th>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Karyawan</th>
                    <th>Total Gaji</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<span class="d-none" id="year"><?= $year; ?></span>
<span class="d-none" id="month"><?= $month; ?></span>
<span class="d-none" id="empId"><?= $empId; ?></span>
<span class="d-none" id="rows"><?= $rows; ?></span>

<div id="tmpModal"></div>