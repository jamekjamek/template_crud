<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href=" https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
  <?php if ($this->uri->segment(2) === 'tambah' || $this->uri->segment(2) === 'ubah') : ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <?php endif; ?>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <title>Document</title>
</head>

<body>