<h4 class="fw-bold py-3"><span class="text-muted fw-light"></span> Pengaturan</h4>
<!-- Form with Tabs -->
<div class="row">
    <div class="col">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tabs-general" role="tab" aria-selected="true">
                            Umum
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-calculation" role="tab" aria-selected="false">
                            Perhitungan
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade active show" id="form-tabs-general" role="tabpanel">
                    <form action="" method="POST" id="form-edit">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <input type="hidden" name="id" class="form-control" value="<?= $identity['id']; ?>" />
                                <label class="form-label" for="company">Nama Instansi</label>
                                <input type="text" id="company" name="company" class="form-control" placeholder="PT. .." value="<?= $identity['company']; ?>" />
                                <div id="form-error"></div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label" for="signin_time">Jam Masuk Kerja</label>
                                <input type="time" id="signin_time" name="signin_time" class="form-control" placeholder="Waktu Masuk" value="<?= $identity['start_work_time']; ?>" />
                                <div id="form-error"></div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label" for="signout_time">Jam Pulang Kerja</label>
                                <input type="time" id="signout_time" name="signout_time" class="form-control" placeholder="Waktu Masuk" value="<?= $identity['end_work_time']; ?>" />
                                <div id="form-error"></div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <p class="text-muted m-0" style="font-size: 0.75rem">&nbsp;</p>
                                <label class="form-label" for="favicon">Favicon</label>
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img class="d-block rounded" style="max-width: 50px" src="<?= base_url('assets/data/logo/' . $identity['favicon']); ?>" alt="Favicon" id="uploadedFavicon" />
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                            <span class="d-none d-sm-block">Upload Favicon</span>
                                            <i class="ti ti-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" name="favicon" class="account-file-input-favicon" hidden accept="image/*" />
                                        </label>
                                        <button type="button" class="btn btn-label-secondary account-image-reset-favicon mb-3">
                                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>
                                        <div class="text-muted" style="font-size: 12px">Allowed JPG, SVG or PNG. Max size of 3MB</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <p class="text-muted m-0" style="font-size: 0.75rem">&nbsp;</p>
                                <label class="form-label" for="logo1">Logo</label>
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img class="d-block rounded" style="max-width: 50px" src="<?= base_url('assets/data/logo/' . $identity['sidebar']); ?>" alt="logo1" id="uploadedLogo1" />
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                            <span class="d-none d-sm-block">Upload Logo</span>
                                            <i class="ti ti-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" name="logo1" class="account-file-input-logo1" hidden accept="image/*" />
                                        </label>
                                        <button type="button" class="btn btn-label-secondary account-file-input-logo1 mb-3">
                                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>
                                        <div class="text-muted" style="font-size: 12px">Allowed JPG, SVG or PNG. Max size of 3MB</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <hr>
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 btnSubmit">Simpan</button>
                        </div>
                </div>
                <div class="tab-pane fade" id="form-tabs-calculation" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="fixed_incentives">Insentif</label>
                            <p class="text-muted m-0" style="font-size: 0.75rem">Untuk karyawan tetap dengan masa kerja > 1 tahun</p>
                            <input type="text" id="fixed_incentives" name="fixed_incentives" class="form-control" placeholder="Masukkan insentif untuk karyawan tetap" value="<?= $identity['fixed_incentives']; ?>" />
                            <div id="form-error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="additional_incetives">Penambah Insentif</label>
                            <p class="text-muted m-0" style="font-size: 0.75rem">Penambahan untuk masa kerja > 1 tahun</p>
                            <input type="text" id="additional_incetives" name="additional_incetives" class="form-control" placeholder="Masukkan penambah insentif untuk karyawan tetap" value="<?= $identity['additional_incetives']; ?>" />
                            <div id="form-error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="annual_working_hours">Pembagi Lembur</label>
                            <input type="text" id="annual_working_hours" name="annual_working_hours" class="form-control" placeholder="Masukkan pembagi lembur" value="<?= $identity['annual_working_hours']; ?>" />
                            <div id="form-error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="NWNP_deduction">Pembagi NWNP</label>
                            <input type="text" id="NWNP_deduction" name="NWNP_deduction" class="form-control" placeholder="Masukkan pembagi NWNP" value="<?= $identity['NWNP_deduction']; ?>" />
                            <div id="form-error"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="BPJS_deduction">Pembagi BPJS</label>
                            <input type="text" id="BPJS_deduction" name="BPJS_deduction" class="form-control" placeholder="Masukkan pembagi BPJS" value="<?= $identity['BPJS_deduction']; ?>" />
                            <div id="form-error"></div>
                        </div>
                    </div>
                    <div class="pt-4">
                        <hr>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 btnSubmit">Simpan</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>