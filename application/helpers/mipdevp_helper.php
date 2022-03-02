<?php
//LOGIN TEMPLATE
function templateAuth($page = '', $data = [])
{
  $mip = get_instance();
  $mip->load->view('authentication/template/header', $data);
  $mip->load->view('authentication/' . $page, $data);
  $mip->load->view('authentication/template/footer');
}
