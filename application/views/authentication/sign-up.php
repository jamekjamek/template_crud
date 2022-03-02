<div class="login-form">
  <form action="" method="post">
    <h2 class="text-center">Daftar</h2>
    <div class="form-group">
      <input type="text" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" placeholder="Email" name="email" value="<?= set_value('email') ?>">
      <div class="invalid-feedback">
        <?= form_error('email'); ?>
      </div>
    </div>
    <div class="form-group">
      <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" placeholder="Password" name="password" value="<?= set_value('password') ?>">
      <div class="invalid-feedback">
        <?= form_error('password'); ?>
      </div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control <?= form_error('full-name') ? 'is-invalid' : '' ?>" placeholder="Nama Lengkap" name="full-name" value="<?= set_value('full-name') ?>">
      <div class="invalid-feedback">
        <?= form_error('full-name'); ?>
      </div>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary btn-block">Daftar Sekarang</button>
    </div>
    <div class="clearfix">
      <label class="float-left form-check-label"><input type="checkbox"> Remember me</label>
      <a href="#" class="float-right">Lupa password?</a>
    </div>
  </form>
  <p class="text-center"><a href="#">Login</a></p>
</div>