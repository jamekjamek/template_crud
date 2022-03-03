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

  public function getDataUser()
  {
    $this->_join();
    if ((int)$this->input->post('length') !== -1) {
      $this->db->limit($this->input->post('length'), $this->input->post('start'));
    }
    return $this->db->get($this->table);
  }

  public function countRecordsTotal()
  {
    $this->db->select('*');
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  private function _join()
  {
    if (@$this->input->post('search')['value']) {
      $this->db->like('full_name', $this->input->post('search')['value']);
    }
    if ($this->input->post('order')) {
      $this->db->order_by('email', $this->input->post('order')['0']['dir']);
    } else {
      $this->db->order_by('id', 'DESC');
    }
  }

  public function countRecordsFiltered()
  {
    $this->_join();
    return $this->db->get($this->table);
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
