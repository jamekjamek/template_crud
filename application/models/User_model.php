<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table  = 'm_user';
  }

  public function insert($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->affected_rows();
  }
}
