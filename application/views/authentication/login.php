<div class="login-form">
  <form action="" method="post">
    <h2 class="text-center">Log in</h2>
    <div class="form-group">
      <input type="text" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" placeholder="Email" name="email" value="<?= set_value('email') ?>">
      <div class="invalid-feedback">
        <?= form_error('email') ?>
      </div>
    </div>
    <div class="form-group">
      <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>" placeholder="Password" name="password" value="<?= set_value('password') ?>">
      <div class="invalid-feedback">
        <?= form_error('password') ?>
      </div>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary btn-block">Log in</button>
    </div>
    <div class="clearfix">
      <!-- <label class="float-left form-check-label"><input type="checkbox"> Remember me</label> -->
      <a href="<?= base_url('lupa-password') ?>" class="float-right">Forgot Password?</a>
    </div>
  </form>
  <p class="text-center"><a href="<?= base_url('daftar-akun') ?>">Create an Account</a></p>
</div>

<?php if ($this->session->flashdata('success')) : ?>
  <div class="flashdata" data-flashdata=" <?= $this->session->flashdata('success') ?>" data-type="success"></div>
<?php elseif ($this->session->flashdata('error')) : ?>
  <div class="flashdata" data-flashdata=" <?= $this->session->flashdata('error') ?>" data-type="error"></div>
<?php endif; ?>
<?php unsetFlash(); ?>