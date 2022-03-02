<div class="login-form">
  <form action="" method="post">
    <h2 class="text-center">Reset Password</h2>
    <div class="form-group">
      <input type="text" class="form-control " placeholder="Email" name="email" value="<?= $email; ?>" disabled>
    </div>

    <div class="form-group">
      <input type="password" class="form-control <?= form_error('new-password') ? 'is-invalid' : ''; ?>" placeholder="Password Baru" name="new-password" value="<?= set_value('new-password') ?>">
      <div class="invalid-feedback">
        <?= form_error('new-password'); ?>
      </div>
    </div>

    <div class="form-group">
      <input type="password" class="form-control <?= form_error('confirm-password') ? 'is-invalid' : ''; ?>" placeholder="Konfirmasi Password Baru" name="confirm-password" value="<?= set_value('confirm-password') ?>">
      <div class="invalid-feedback">
        <?= form_error('confirm-password'); ?>
      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
    </div>
  </form>
</div>