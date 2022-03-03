<div class="container mt-4">
  <div class="row justify-content-md-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title d-flex justify-content-between">
            <a class="btn btn-primary" href="<?= base_url('home/tambah') ?>">Tambah Data</a>
            <div>
              <span class="h6">Admin</span>
              <a href="<?= base_url('keluar'); ?>" class="btn btn-link">Logout</a>
            </div>
          </h5>
          <table id="crud-table" class="table table-striped table-bordered table-responsive" style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Level</th>
                <th>User Status</th>
                <th>Deleted Status</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<?php if ($this->session->flashdata('success')) : ?>
  <div class="flashdata" data-flashdata=" <?= $this->session->flashdata('success') ?>" data-type="success"></div>
<?php elseif ($this->session->flashdata('error')) : ?>
  <div class="flashdata" data-flashdata=" <?= $this->session->flashdata('error') ?>" data-type="error"></div>
<?php endif; ?>
<?php unsetFlash(); ?>