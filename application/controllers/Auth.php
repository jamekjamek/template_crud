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
    if ($this->session->userdata('userdata')) {
      redirect('home');
    }
    $this->_validation('login');
    if ($this->form_validation->run() === FALSE) {
      $page  = 'login';
      $data  = [];
      templateAuth($page, $data);
    } else {
      $this->_login();
    }
  }

  private function _login()
  {
    $email    = $this->input->post('email');
    $password = $this->input->post('password');
    $where    = [
      'email' => $email
    ];
    $userData   = $this->User->getDataBy($where);
    if ($userData->num_rows() > 0) {
      $userData = $userData->row();
      if (password_verify($password, $userData->password)) {
        if ($userData->is_active === '1') {
          $session  = ['userdata' => [
            'id'          => encodeEncrypt($userData->id),
            'email'       => $userData->email,
            'full_name'   => $userData->full_name,
            'level'       => $userData->level,
            'updated_at'  => $userData->updated_at
          ]];
          $this->session->set_userdata($session);
          redirect('home');
        } else {
          $this->session->set_flashdata('error', 'User sudah tidak aktif');
          redirect('auth/login');
        }
      } else {
        $this->session->set_flashdata('error', 'Password Salah');
        redirect('auth/login');
      }
    } else {
      $this->session->set_flashdata('error', 'Data user tidak ditemukan');
      redirect('auth/login');
    }
  }

  public function sign_up()
  {
    $this->_validation('sign-up');
    if ($this->form_validation->run() === FALSE) {
      $page  = 'sign-up';
      $data  = [];
      templateAuth($page, $data);
    } else {
      $this->_sign_up();
    }
  }

  private function _sign_up()
  {
    $email      = $this->input->post('email');
    $fullName   = $this->input->post('full-name');
    $dataInsert = [
      'email'     => htmlspecialchars($email),
      'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
      'full_name' => htmlspecialchars($fullName),
      'level'     => 'Admin',
      'is_active' => '0',
      'is_delete' => '0',
    ];
    $insert     = $this->User->insert($dataInsert);
    if ($insert > 0) {
      $dataEmail = [
        'email'     => $email,
        'full_name' => $fullName,
      ];
      $sendEmail = $this->_sendEmailPHPMailer($dataEmail, 'sign-up');
      if ($sendEmail) {
        $this->session->set_flashdata('success', 'Email Pendaftaran berhasil di kirim , silahkan cek');
        redirect('auth/login');
      }
    } else {
      $this->session->set_flashdata('error', 'Data Gagal di Tambahkan');
      redirect('auth/login');
    }
  }

  public function forgot_password()
  {
    $this->_validation('forgot-password');
    if ($this->form_validation->run() === FALSE) {
      $page  = 'forgot-password';
      $data  = [];
      templateAuth($page, $data);
    } else {
      $this->_forgot_password();
    }
  }

  private function _forgot_password()
  {
    $email    = $this->input->post('email');
    $rowData  = $this->User->getDataBy(['email' => $email]);
    if ($rowData->num_rows() > 0) {
      $rowToken = $this->User->getDataTokenBy(['email' => $email]);
      if ($rowToken->num_rows() <= 0) {
        $randomString = random_string('alpha', 20);
        $dataToken  = [
          'email'   => htmlspecialchars($email),
          'token'   => encodeEncrypt($randomString),
        ];
        $insert       = $this->User->insert_token($dataToken);
        if ($insert > 0) {
          $sendEmail  = $this->_sendEmailPHPMailer($dataToken, 'forgot-password');
          if ($sendEmail) {
            $this->session->set_flashdata('success', 'Link Reset Password berhasil di kirim , silahkan cek');
            redirect('auth/login');
          }
        } else {
          $this->session->set_flashdata('error', 'Data Token Gagal di Tambahkan');
          redirect('auth/login');
        }
      } else {
        $dataToken  = [
          'email'   => htmlspecialchars($email),
          'token'   => $rowToken->row()->token
        ];
        $sendEmail  = $this->_sendEmailPHPMailer($dataToken, 'forgot-password');
        if ($sendEmail) {
          $this->session->set_flashdata('success', 'Link Reset Password berhasil di kirim , silahkan cek');
          redirect('auth/login');
        }
      }
    }
  }

  public function reset_password($email, $token)
  {
    $where    = [
      'email' => $email,
      'token' => $token
    ];
    $rowToken = $this->User->getDataTokenBy($where);

    if ($rowToken->num_rows() > 0) {
      $this->_validation('reset-password');
      if ($this->form_validation->run() === FALSE) {
        $page  = 'reset-password';
        $data  = $where;
        templateAuth($page, $data);
      } else {
        $this->_reset_password($email);
      }
    } else {
      $this->session->set_flashdata('error', 'Data yang di minta tidak ada');
      redirect('auth/login');
    }
  }

  private function _reset_password($email)
  {
    $newPassword  = $this->input->post('new-password');
    $dataUpdate   = [
      'password'    => password_hash($newPassword, PASSWORD_DEFAULT),
      'updated_at'  => date('Y-m-d H:i:s')
    ];
    $where        = [
      'email'     => $email
    ];

    $update       = $this->User->update($dataUpdate, $where);
    if ($update > 0) {
      $this->User->deleteToken(['email' => $email]);
      $this->session->set_flashdata('success', 'Reset Password Berhasil, silahkan login');
    } else {
      $this->session->set_flashdata('error', 'Reset Password gagal, silahkan coba lagi');
    }
    redirect('auth/login');
  }

  public function activation($email)
  {
    //AKTIVASI Sederhana nanti bisa di tambahkan menggunakan token dan sebagainya
    $rowData  = $this->User->getDataBy(['email' => $email]);
    if ($rowData->num_rows() > 0) {
      $dataUpdate = [
        'is_active' => '1',
      ];
      $where      = [
        'email'   => $email,
      ];
      $update     = $this->User->update($dataUpdate, $where);
      if ($update > 0) {
        $this->session->set_flashdata('success', 'Akun Berhasil di aktivasi, Silahkan Login');
        redirect('auth/login');
      } else {
        $this->session->set_flashdata('error', 'Server sedang sibuk, silahkan coba lagi');
        redirect('auth/login');
      }
    } else {
      echo "Data tidak ada";
    }
  }

  public function log_out()
  {
    $this->session->sess_destroy();
    $this->session->set_flashdata('success', 'Anda Telah Logout');
    redirect('auth/login');
  }

  private function _validation($type = null)
  {
    if ($type === 'login') {
      $this->form_validation->set_rules(
        'email',
        'Email',
        'trim|required|valid_email',
        [
          'required'    => '%s Wajib diisi',
          'valid_email' => 'Format %s Salah',
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
    }
    if ($type === 'sign-up') {
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
    if ($type === 'forgot-password') {
      $this->form_validation->set_rules(
        'email',
        'Email',
        'trim|required|valid_email',
        [
          'required'    => '%s Wajib diisi',
          'valid_email' => 'Format %s Salah',
        ]
      );
    }
    if ($type === 'reset-password') {
      $this->form_validation->set_rules(
        'new-password',
        'Password Baru',
        'trim|required|min_length[6]|max_length[12]',
        [
          'required'    => '%s Wajib diisi',
          'min_length'  => '%s Minimal 6 Karakter',
          'max_length'  => '%s Maksimal 10 Karakter',
        ]
      );

      $this->form_validation->set_rules(
        'confirm-password',
        'Konfirmasi Password Baru',
        'trim|required|min_length[6]|max_length[12]|matches[new-password]',
        [
          'required'    => '%s Wajib diisi',
          'min_length'  => '%s Minimal 6 Karakter',
          'max_length'  => '%s Maksimal 10 Karakter',
          'matches'     => '%s tidak cocok'
        ]
      );
    }
  }

  private function  _sendEmailPHPMailer($data, $type)
  {
    //Server settings
    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail = PHPMailer();
    if ($type === 'sign-up') {
      $mail->setFrom('templatecrud@gmail.com', 'Template CRUD Email Pengirim'); //bisa diubah emailnya sesuai keinginan : EMail Pengirim
      $mail->addAddress('' . $data['email'] . '', '' . $data['full_name'] . ''); //Email Penerima dan nama Penerima
      $mail->addReplyTo('hardiyantoagung55@gmail.com', 'No Reply'); //bisa diubah email jawabannya sesuai keinginan
      $mail->addBCC('agunghardiyanto12@gmail.com');
      $mail->isHTML(true);
      $mail->Subject  = 'Pendaftaran Akun';
      //Body bisa di load ke view 
      $body           = 'Silahkan Klik Link ini untuk mengaktifkan <a href="' . base_url('aktivasi/' . $data['email'] . '">' . base_url('aktivasi/' . $data['email']) . '</a>');
    }

    if ($type === 'forgot-password') {
      $mail->setFrom('templatecrud@gmail.com', 'Template CRUD Email Pengirim');
      $mail->addAddress('' . $data['email'] . '', '');
      $mail->addReplyTo('hardiyantoagung55@gmail.com', 'No Reply');
      $mail->addBCC('agunghardiyanto12@gmail.com');
      $mail->isHTML(true);
      $mail->Subject  = 'Reset Password Akun';
      $body           = 'Silahkan Klik Link ini untuk reset password <a href="' . base_url('reset-password/' . $data['email'] . '/' . $data['token'] . '">' . base_url('reset-password/' . $data['email']) . '/' . $data['token'] . '</a>');
    }

    $mail->Body   = $body;
    if (!$mail->send()) {
      echo "Email Error: " . $mail->ErrorInfo;
    } else {
      return true;
    }
  }
}
