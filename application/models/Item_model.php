<?php

class Item_model extends CI_Model
{
    private $_table = 'm_barang';

    public function addItem($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function getItem($id)
    {
        return $this->db->get_where($this->_table, ['id' => $id])->row_array();
    }

    public function getAllItem($key)
    {
        $this->db->like('nama', $key);
        return $this->db->get($this->_table)->result_array();
    }
}
