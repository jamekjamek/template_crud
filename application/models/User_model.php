<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table  = 'm_user';
    $this->tableToken = 't_token';
  }

  public function getDataBy($data)
  {
    return $this->db->get_where($this->table, $data);
  }

  public function insert($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->affected_rows();
  }

  public function update($data, $where)
  {
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }

  public function insert_token($data)
  {
    $this->db->insert($this->tableToken, $data);
    return $this->db->affected_rows();
  }

  public function getDataTokenBy($data)
  {
    return $this->db->get_where($this->tableToken, $data);
  }

  public function deleteToken($where)
  {
    $this->db->delete($this->tableToken, $where);
    return $this->db->affected_rows();
  }
}
