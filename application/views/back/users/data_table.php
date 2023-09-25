<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manajemen Pengguna /</span> Data Pengguna</h4>

<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table">
            <thead>
                <tr>
                    <th></th>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="tmpModal"></div>
<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record" action="" method="POST">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">User Baru</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form class="add-new-record pt-0 row g-2" id="form-add-new-record">
            <div class="col-sm-12">
                <label class="form-label" for="role">Role</label>
                <div class="input-group input-group-merge">
                    <span id="role2" class="input-group-text"><i class="ti ti-user"></i></span>
                    <select class="form-select dt-role" id="role" name="role">
                        <option value="" selected="" disabled>Pilih Role</option>
                        <?php foreach ($role as $row) : ?>
                            <option value="<?= $row; ?>"><?= strtoupper($row); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="username">Username</label>
                <div class="input-group input-group-merge">
                    <span id="username2" class="input-group-text"><i class="ti ti-user-circle"></i></span>
                    <input type="text" id="username" name="username" class="form-control dt-username" placeholder="johndoe" />
                </div>
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="email">Email</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                    <input type="text" id="email" name="email" class="form-control dt-email" placeholder="john.doe@example.com" />
                </div>
                <!--<div class="form-text">You can use letters, numbers & periods</div>-->
            </div>
            <div class="col-sm-12 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                    <!--<span id="password2" class="input-group-text"><i class="ti ti-lock"></i></span>-->
                    <input type="password" class="form-control dt-password" id="password" name="password" placeholder="********" />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
            </div>
            <div class="col-sm-12 form-password-toggle">
                <label class="form-label" for="confirmPassword">Konfirmasi Password</label>
                <div class="input-group input-group-merge">
                    <!--<span id="confirmPassword2" class="input-group-text"><i class="ti ti-lock"></i></span>-->
                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control dt-confirm-password" placeholder="********" />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
            </div>
            <div class="col-sm-12">
                <button type="submit" id="btnAdd" class="btn btn-primary data-submit me-sm-3 me-1">Tambah</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>