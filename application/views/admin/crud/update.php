<div class="container mt-4">
  <div class="row justify-content-md-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title d-flex justify-content-between">
            <span class="h5">Tambah Data</span>
          </h5>
          <form action="" method="POST">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" id="email" placeholder="Masukan Email" name="email" value="<?= set_value('email') ? set_value('email') : $user->email; ?>">
              <div class="invalid-feedback">
                <?= form_error('email'); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>" id="password" placeholder="Masukan Password" name="password" value="<?= set_value('password') ? set_value('password') : $user->password; ?>">
              <div class="invalid-feedback">
                <?= form_error('password'); ?>
              </div>
            </div>

            <div class="form-group">
              <label for="full-name">Nama Lengkap</label>
              <input type="text" class="form-control <?= form_error('full-name') ? 'is-invalid' : ''; ?>" id="full-name" placeholder="Masukan Nama Lengkap" name="full-name" value="<?= set_value('full-name') ? set_value('full-name') : $user->full_name; ?>">
              <div class="invalid-feedback">
                <?= form_error('full-name'); ?>
              </div>
            </div>

            <div class="form-group">
              <label for="full-name">Level</label>
              <select class="level form-control <?= form_error('level') ? 'is-invalid' : ''; ?>" name="level">
                <option></option>
                <?php if ($user->level === 'Admin') : ?>
                  <option value="Admin" selected>Admin</option>
                  <option value="Pengguna">Pengguna</option>
                <?php else : ?>
                  <option value="Admin">Admin</option>
                  <option value="Pengguna" selected>Pengguna</option>
                <?php endif; ?>
              </select>
              <div class="invalid-feedback">
                <?= form_error('level'); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <br />
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="1" value="1" <?= $user->is_active === '1' ? 'checked="checked"' : '' ?>>
                <label class="form-check-label" for="1">Aktif</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="0" value="0" <?= $user->is_active === '0' ? 'checked="checked"' : '' ?>>
                <label class="form-check-label" for="0">Tidak Aktif</label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class="btn btn-danger" href="<?= base_url('home'); ?>">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>