<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Crud extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('User_model', 'User');
    if (!$this->session->userdata('userdata')) {
      $this->session->set_flashdata('error', 'Anda Harus Login dahalu');
      redirect('auth/login');
    }
    $this->redirect = 'home';
  }

  public function index()
  {
    $page = 'index';
    $data = [];
    crudPage($page, $data);
  }

  public function create()
  {
    $this->_validation();
    if ($this->form_validation->run() === false) {
      $page = 'create';
      crudPage($page);
    } else {
      $this->_create();
    }
  }

  private function _create()
  {
    $email      = htmlspecialchars($this->input->post('email'));
    $password   = $this->input->post('password');
    $fullName   = htmlspecialchars($this->input->post('full-name'));
    $level      = $this->input->post('level');
    $isActive   = $this->input->post('status');

    $dataInsert = [
      'email'     => $email,
      'password'  => $password,
      'full_name' => $fullName,
      'level'     => $level,
      'is_active' => $isActive,
      'is_delete' => '0'
    ];
    $insert     = $this->User->insert($dataInsert);
    if ($insert > 0) {
      $this->session->set_flashdata('success', 'Data Berhasil di tambah');
      redirect($this->redirect);
    } else {
      $this->session->set_flashdata('error', 'Data Gagal di Tambahkan');
      redirect($this->redirect);
    }
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

  private function _validation()
  {
    $this->form_validation->set_rules(
      'email',
      'Email',
      'trim|required|valid_email|is_unique[m_user.email]',
      [
        'required'    => '%s Wajib diisi',
        'valid_email' => 'Format %s Salah',
        'is_unique'   => '%s sudah terdaftar',
      ]
    );

    $this->form_validation->set_rules(
      'password',
      'Password',
      'trim|required|min_length[6]|max_length[12]',
      [
        'required'    => '%s Wajib diisi',
        'min_length'  => '%s Minimal 6 Karakter',
        'max_length'  => '%s Maksimal 10 Karakter',
      ]
    );

    $this->form_validation->set_rules(
      'full-name',
      'Nama Lengkap',
      'trim|required',
      [
        'required'    => '%s Wajib diisi',
      ]
    );

    if ($this->input->post('level') === "") {
      $this->form_validation->set_rules(
        'level',
        'Level',
        'trim|required',
        [
          'required'  => '%s Wajib diisi'
        ]
      );
    }
  }
}
