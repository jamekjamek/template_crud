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

    echo "<pre>";
    print_r($this->session->userdata('userdata'));
    echo "</pre>";
    $this->session->sess_destroy();
    die;
  }
}
