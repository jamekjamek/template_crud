<?php

use PHPMailer\PHPMailer\PHPMailer;

function templateAuth($page = null, $data = null)
{
  $mip = get_instance();
  $mip->load->view('authentication/template/header', $data);
  $mip->load->view('authentication/' . $page, $data);
  $mip->load->view('authentication/template/footer');
}

function crudPage($page = null, $data = null)
{
  $mip = get_instance();
  $mip->load->view('admin/template/header', $data);
  $mip->load->view('admin/crud/' . $page, $data);
  $mip->load->view('admin/template/footer');
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

function unsetFlash()
{
  if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
  }
  if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
  }
}

function keyencrypt()
{
  return 'xWeQSDEraxvftnabsyeirytcnsaVBFSH856SNEbsgatw791';
}

function encodeEncrypt($id)
{
  $mip = get_instance();
  return $mip->encrypt->encode($id, keyencrypt());
}

function decodeEncrypt($id)
{
  $mip = get_instance();
  return $mip->encrypt->decode($id, keyencrypt());
}
