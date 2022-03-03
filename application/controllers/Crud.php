<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Crud extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('User_model', 'User');
  }

  public function index()
  {
    // for ($i = 0; $i < 100; $i++) {
    //   $dataInsert = [
    //     'email'     => htmlspecialchars(random_string('alpha', 20)),
    //     'password'  => password_hash(random_string('alnum', 10), PASSWORD_DEFAULT),
    //     'full_name' => htmlspecialchars(random_string('alpha', 25)),
    //     'level'     => 'Admin',
    //     'is_active' => '1',
    //     'is_delete' => '0',
    //   ];
    //   $this->User->insert($dataInsert);
    // }

    $page = 'index';
    $data = [
      'users' => $this->User->getDataUser()->result()
    ];
    crudPage($page, $data);
  }

  public function create()
  {
    $page = 'create';
    crudPage($page);
  }

  public function datatable()
  {
    $users  = $this->User->getDataUser()->result();
    $data   = [];
    $no = $_POST['start'];
    foreach ($users as $user) {
      $row = array();
      $row[] = ++$no;
      $row[] = $user->email;
      $row[] = $user->full_name;
      $row[] = $user->level;
      if ($user->is_active === '1') {
        $row[]  = '<span class="badge badge-pill badge-primary mb-1">Aktif</span>';
      } else {
        $row[]  = '<span class="badge badge-pill badge-danger mb-1">Tidak Aktif</span>';
      }
      if ($user->is_delete === '0') {
        $row[]  = '<span class="badge badge-pill badge-success mb-1">Belum dihapus</span>';
      } else {
        $row[]  = '<span class="badge badge-pill badge-danger mb-1">Sudah dihapus</span>';
      }

      $row[] = '
        <div class="btn-group">
          <a href="' . base_url('admin/master/student/edit/' . encodeEncrypt($user->id)) . '" class="btn btn-success"><i class="ik ik-edit"></i>Edit</a>
          <button type="button" class="btn btn-danger delete-student" data-id="' . encodeEncrypt($user->id) . '"><i class=" ik ik-trash"></i>Hapus</button>
        </div>
      ';
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->User->countRecordsTotal(),
      "recordsFiltered" => $this->User->countRecordsFiltered()->num_rows(),
      "data" => $data,
    );
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($output));
  }
}
