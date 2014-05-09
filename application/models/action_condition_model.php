<?php

class Action_condition_model extends CI_Model{
    private $_table_name = 'action_conditions';

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

    public function get_list($order_by = "c.id", $condition = "DESC")
    {
        $this->db->select('*');
        $this->db->from($this->_table_name . ' c');
        $this->db->join('actions a', 'c.action_id = a.id');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_action_id($action_id)
    {
        $this->db->select('c.*, d.device_name, ps.property_name, v.min_value, v.max_value, u.unit_name');
        $this->db->from($this->_table_name . ' c');
        $this->db->where('c.action_id', $action_id);
        $this->db->join('devices d', 'c.row_device_id = d.id');
        $this->db->join('device_types t', 'd.device_type_id = t.id');
        $this->db->join('device_type_properties p', 'p.device_type_id = t.id', 'left');
        $this->db->join('device_properties ps', 'p.property_id = ps.id', 'left');
        $this->db->join('device_property_values v', 'v.property_id = p.property_id', 'left');
        $this->db->join('units u', 'u.id = v.unit', 'left');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_action_id_to_delete($action_id)
    {
        $this->db->select('id');
        $this->db->from($this->_table_name);
        $this->db->where('action_id', $action_id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->_table_name . ' c');
        $this->db->where("c.id", $id);
        $this->db->join('actions a', 'c.action_id = a.id');
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

}
