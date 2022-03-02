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
          echo "Email Terkirim";
        }
      } else {
        echo "Gagal insert";
      }
    }
  }

  public function forgot_password()
  {
    $page  = 'forgot-password';
    $data  = [];
    templateAuth($page, $data);
  }



  //AKTIVASI Sederhana nanti bisa di tambahkan menggunakan token dan sebagainya
  public function activation($email)
  {
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
        echo "data berhasil di update";
      } else {
        echo "Server sedang sibuk, gagal update";
      }
    } else {
      echo "Data tidak ada";
    }
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
      $body           = 'Silahkan Klik Link ini untuk mengaktifkan' . base_url('aktivasi/' . $data['email']);
    }
    $mail->Body   = $body;
    if (!$mail->send()) {
      echo "Email Error: " . $mail->ErrorInfo;
    } else {
      return true;
    }
  }
}
