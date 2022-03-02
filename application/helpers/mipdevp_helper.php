<?php
//LOGIN TEMPLATE

use PHPMailer\PHPMailer\PHPMailer;

function templateAuth($page = '', $data = [])
{
  $mip = get_instance();
  $mip->load->view('authentication/template/header', $data);
  $mip->load->view('authentication/' . $page, $data);
  $mip->load->view('authentication/template/footer');
}


function PHPMailer()
{
  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->SMTPDebug  = 0;
  $mail->Debugoutput = 'html';
  $mail->Host       = 'smtp.gmail.com';
  $mail->Port       = 465;
  $mail->SMTPSecure = 'ssl';
  $mail->SMTPAuth   = true;
  $mail->Username   = 'templatecrud@gmail.com';
  $mail->Password   = 'ReactNative1234%';
  return $mail;
}
