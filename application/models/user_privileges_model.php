<?php

class User_privileges_model extends CI_Model{
    private $_table_name = 'user_privileges';

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

    public function get_list($order_by = "username", $condition = "ASC")
    {
        $this->db->select('u.id AS user_id, u.user_group, u.username, u.email, u.is_active, u.created_date, g.group_name');
        $this->db->from($this->_table_name . ' u');
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

    public function get_by_account($group_id, $user_id)
    {
        if($group_id == USER_GROUP_BUILDINGS_OWNER) {
            $this->db->select('u.id as privilege_id, u.building_id, b.building_name');
            $this->db->join('buildings b', 'b.id = u.building_id');
        }
        else if($group_id == USER_GROUP_ROOMS_ADMIN) {
            $this->db->select('u.id as privilege_id, u.room_id, r.room_name');
            $this->db->join('rooms r', 'r.id = u.room_id');
        }

        $this->db->from($this->_table_name. ' u');
        $this->db->where('user_account', $user_id);
        $query = $this->db->get();

        return $query->result_array();
    }

}
