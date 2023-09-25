<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Data Karyawan </h4>

<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table">
            <thead>
                <tr>
                    <th class="text-nowrap"></th>
                    <th class="text-nowrap">No</th>
                    <th class="text-nowrap">Nama</th>
                    <th class="text-nowrap">Tempat Lahir</th>
                    <th class="text-nowrap">Tanggal Lahir</th>
                    <th class="text-nowrap">Jenis Kelamin</th>
                    <th class="text-nowrap">Jabatan</th>
                    <th class="text-nowrap">Status</th>
                    <th class="text-nowrap">Gaji Pokok</th>
                    <th class="text-nowrap">Tunjangan</th>
                    <th class="text-nowrap">Tanggal Masuk</th>
                    <th class="text-nowrap">BPJS</th>
                    <th class="text-nowrap">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="tmpModal"></div>

<!-- Modal to add new record -->
<div class="modal fade" id="modal-add" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Tambah Data Karyawan</h3>
                </div>
                <form id="form-add" class="row g-3" action="" method="POST">
                    <div class="col-md-12 name">
                        <label class="form-label" for="name">Nama Karyawan</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama Karyawan" />
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-md-6 birth_place">
                        <label class="form-label" for="birth_place">Tempat Lahir</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="birth_place" name="birth_place" class="form-control" placeholder="Masukkan Tempat Lahir Karyawan" />
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 birth_date">
                        <label class="form-label" for="birth_date">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" class="form-control" />
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 col-md-12 gender">
                        <label class="form-label" class="form-label" for="gender">Jenis Kelamin</label>
                        <div class="input-group">
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="gender" id="gender_lk" value="Laki-laki" checked />
                                <label class="form-check-label" for="gender_lk">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="gender" id="gender_pr" value="Perempuan" />
                                <label class="form-check-label" for="gender_pr">Perempuan</label>
                            </div>
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-md-6 job_designation">
                        <label class="form-label" for="job_designation">Jabatan</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="job_designation" name="job_designation" class="form-control" placeholder="Masukkan Jabatan Karyawan" />
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-md-6 status">
                        <label class="form-label" for="status">Status Karyawan</label>
                        <div class="input-group input-group-merge">
                            <select class="form-select" id="status" name="status">
                                <option value="" selected="" disabled>Pilih Status Karyawan</option>
                                <option value="Tetap">Tetap</option>
                                <option value="Kontrak">Kontrak</option>
                                <option value="HL">HL</option>
                            </select>
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 col-md-12 basic_salary">
                        <label class="form-label" for="basic_salary">Gaji Pokok</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="basic_salary" name="basic_salary" maxlength="13" class="form-control" placeholder="Rp. 100.000" />
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 col-md-12 allowance">
                        <label class="form-label" for="allowance">Tunjangan</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="allowance" name="allowance" maxlength="13" class="form-control" placeholder="Rp. 100.000" />
                        </div>
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6 date_of_join">
                        <label class="form-label" for="date_of_join">Tanggal Masuk</label>
                        <input type="date" id="date_of_join" name="date_of_join" class="form-control" />
                        <div id="form-error"></div>
                    </div>
                    <div class="col-lg-6">
                        <label for="information_tag" class="form-label">Ikut BPJS</label>
                        <p class="m-2"></p>
                        <label class="switch switch-success">
                            <input type="checkbox" name="has_BPJS" class="switch-input" />
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