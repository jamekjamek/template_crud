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
    $dataInsert = $this->_data();

    $insert     = $this->User->insert($dataInsert);
    if ($insert > 0) {
      $this->session->set_flashdata('success', 'Data Berhasil di tambah');
      redirect($this->redirect);
    } else {
      $this->session->set_flashdata('error', 'Data Gagal di Tambahkan');
      redirect($this->redirect);
    }
  }

  private function _data($type = null)
  {
    $email      = htmlspecialchars($this->input->post('email'));
    $password   = $this->input->post('password');
    $fullName   = htmlspecialchars($this->input->post('full-name'));
    $level      = $this->input->post('level');
    $isActive   = $this->input->post('status');

    $postData       = [
      'email'     => $email,
      'password'  => password_hash($password, PASSWORD_DEFAULT),
      'full_name' => $fullName,
      'level'     => $level,
      'is_active' => $isActive,
      'is_delete' => '0'
    ];
    if ($type === 'update') {
      $postData     += [
        'updated_at'  => date('Y-m-d H:i:s')
      ];
    }
    return $postData;
  }

  public function update($id)
  {
    $id   = (int)decodeEncrypt($id);
    $user = $this->User->getDataBy(['id' => $id]);
    if ($user->num_rows() > 0) {
      $oldEmail = $user->row()->email;
      $this->_validation($oldEmail);
      if ($this->form_validation->run() === FALSE) {
        $page = 'update';
        $data = [
          'user'  => $user->row()
        ];
        crudPage($page, $data);
      } else {
        $this->_update($id);
      }
    } else {
      $this->session->set_flashdata('error', 'Data yand dipilih tidak ada');
      redirect($this->redirect);
    }
  }

  private function _update($id)
  {
    $dataUpdate = $this->_data('update');
    $where      = ['id' => $id];
    $update     = $this->User->update($dataUpdate, $where);
    if ($update > 0) {
      $this->session->set_flashdata('success', 'Data Berhasil di update');
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
          <a href="' . base_url('home/ubah/' . encodeEncrypt($user->id)) . '" class="btn btn-success"><i class="ik ik-edit"></i>Edit</a>
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

  private function _validation($email = null)
  {
    if ($this->input->post('email') !== $email) {
      $isUnique = '|is_unique[m_user.email]';
    } else {
      $isUnique = '';
    }
    $this->form_validation->set_rules(
      'email',
      'Email',
      'trim|required|valid_email' . $isUnique,
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
