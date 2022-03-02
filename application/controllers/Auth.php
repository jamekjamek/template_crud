<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('User_model', 'User');
  }
  public function login()
  {
    $page  = 'login';
    $data  = [];
    templateAuth($page, $data);
  }

  public function sign_up()
  {
    $this->_validation();
    if ($this->form_validation->run() === FALSE) {
      $page  = 'sign-up';
      $data  = [];
      templateAuth($page, $data);
    } else {
      $dataInsert = [
        'email'     => htmlspecialchars($this->input->post('email')),
        'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        'full_name' => htmlspecialchars($this->input->post('full-name')),
        'level'     => 'Admin',
        'is_active' => '0',
        'is_delete' => '0',
      ];
      $insert     = $this->User->insert($dataInsert);
    }
  }

  public function forgot_password()
  {
    $page  = 'forgot-password';
    $data  = [];
    templateAuth($page, $data);
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
  }
}
