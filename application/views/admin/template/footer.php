<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($this->uri->segment(2) === 'tambah' || $this->uri->segment(2) === 'ubah') : ?>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<?php endif; ?>
<script>
  var base_url = '<?= base_url(); ?>';
</script>
<script src="<?= base_url('assets/admin/crud.js') ?>"></script>
</body>

</html>