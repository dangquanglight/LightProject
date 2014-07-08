<?php

class User_account_model extends CI_Model{
    private $_table_name = 'user_accounts';

    public function insert($arr_data)
    {
        if($this->db->insert($this->_table_name, $arr_data))
            return $this->db->insert_id();
        else
            return FALSE;
    }

    public function update($id, $arr_data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->_table_name , $arr_data) ? TRUE : FALSE;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->_table_name);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function get_list($order_by = "user_group", $condition = "ASC")
    {
        $this->db->select('u.id AS user_id, u.user_group, u.username, u.email, u.is_active, u.created_date, g.group_name');
        $this->db->from($this->_table_name . ' u');
        $this->db->where('u.is_delete', USER_IS_DELETE_FALSE);
        $this->db->join('user_groups g', 'g.id = u.user_group');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    public function get_by_username($username)
    {
        $this->db->where("username", $username);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    public function get_by_email($email)
    {
        $this->db->where("email", $email);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    public function get_by_account($username, $pass)
    {
        $this->db->select('id, user_group, username, is_active, created_date, email');
        $this->db->where(array(
            'username' => $username,
            'password' => $pass,
            'is_delete' => USER_IS_DELETE_FALSE
        ));

        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

}
