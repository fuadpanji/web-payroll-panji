<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Data Presensi </h4>

<!-- DataTable with Buttons -->
<div class="card">
    <div class="row px-5 pt-5">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="attendance" method="POST">
                        <div class="row">
                            <div class="col-lg-4">
                                <label>Karyawan</label>
                                <select class="form-control select2 form-select" name="employee">
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
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col -->
    </div>
    
    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table">
            <thead>
                <tr>
                    <th class="text-nowrap"></th>
                    <th class="text-nowrap">No</th>
                     <th class="text-nowrap">Tanggal Presensi</th> 
                    <th class="text-nowrap">Karyawan</th>
                     <th class="text-nowrap">Waktu Masuk</th>
                    <th class="text-nowrap">Waktu Pulang</th>
                    <th class="text-nowrap">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<span class="d-none" id="year"><?= ($year) ? $year : date('Y'); ?></span>
<span class="d-none" id="month"><?= ($month) ? $month : date('m'); ?></span>
<span class="d-none" id="empId"><?= $empId; ?></span>

<div id="tmpModal"></div>

<!-- Modal to add new record -->
<div class="modal fade" id="modal-add" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Tambah Data Presensi</h3>
                </div>
                <form id="form-add" class="row g-3" action="" method="POST">
                    <div class="col-12">
                        <label class="form-label" for="employee_id">Karyawan </label>
                        <select id="employee_id" name="employee_id" class="employee_id select2 form-select">
                            <option value="" selected disabled>
                                - Pilih Karyawan -
                            </option>
                            <?php foreach ($employees as $employee) { ?>
                                <option value="<?= $employee['employee_id'] ?>">
                                    <?= $employee['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 attendance_date">
                        <label class="form-label" for="attendance_date">Tanggal Presensi</label>
                        <input type="date" id="attendance_date" name="attendance_date" class="form-control" min="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d', strtotime('+7 days')); ?>" placeholder="Tanggal Masuk" />
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 signin_time">
                        <label class="form-label" for="signin_time">Waktu Masuk</label>
                        <input type="time" id="signin_time" name="signin_time" class="form-control" placeholder="Waktu Masuk" />
                        <div id="form-error"></div>
                    </div>
                    <div class="col-12 mt-3 text-center">
                        <button type="submit" id="btnAdd" class="btn btn-primary me-sm-3 me-1">Simpan</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>