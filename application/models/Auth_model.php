<?php

class Auth_model extends CI_Model
{
    private $_table = 'm_user';

    public function getUser($username)
    {
        return $this->db->get_where($this->_table, ['username' => $username])->row_array();
    }
}
