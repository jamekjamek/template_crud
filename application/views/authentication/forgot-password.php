<div class="login-form">
  <form action="" method="post">
    <h2 class="text-center">Lupa Password</h2>
    <div class="form-group">
      <input type="text" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" placeholder="Email" name="email" value="<?= set_value('email') ?>">
      <div class="invalid-feedback">
        <?= form_error('email'); ?>
      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
    </div>

  </form>
  <p class="text-center"><a href="<?= base_url('auth/login') ?>">Login</a></p>
</div>