<?php

class Cust_model extends CI_Model
{
    private $_table = 'm_customer';

    public function getAllCust($key)
    {
        $this->db->like('kode', $key);
        return $this->db->get($this->_table)->result_array();
    }

    public function getCust($id)
    {
        return $this->db->get_where($this->_table, ['id' => $id])->row_array();
    }
}
