<?php

class Device_type_model extends CI_Model{
    private $_table_name = 'device_types';

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

    public function get_list($order_by = "type_name", $condition = "ASC")
    {
        $this->db->select('id AS device_type_id, type_name');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    public function get_by_short_name($short_name)
    {
        $this->db->where("type_short_name", $short_name);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    public function get_by_state_id($id)
    {
        $this->db->select('');
        $this->db->from($this->_table_name);
        $this->db->where("state_id", $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_controller_type($id)
    {
        $this->db->select('id as type_id, state_id');
        $this->db->from($this->_table_name);
        $this->db->where("controller_device", $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_controller_type_and_state($id, $state_id)
    {
        $this->db->select('id as type_id, state_id');
        $this->db->from($this->_table_name);
        $this->db->where("controller_device", $id);
        $this->db->where('state_id', $state_id);
        $query = $this->db->get();

        return $query->result_array();
    }

}
