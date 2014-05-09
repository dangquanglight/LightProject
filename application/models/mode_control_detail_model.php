<?php

class Mode_control_detail_model extends CI_Model{
    private $_table_name = 'mode_control_details';

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

    public function get_list($order_by = "action_id", $condition = "DESC")
    {
        $this->db->from($this->_table_name);
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

    public function get_by_mode_id($mode_id)
    {
        $this->db->select('m.id AS mode_detail_id, m.action_id, a.action_type, a.status, a.device_id AS row_device_id, d.device_name');
        $this->db->from($this->_table_name . ' m');
        $this->db->where("mode_id", $mode_id);
        $this->db->join('actions a', 'a.id = m.action_id');
        $this->db->join('devices d', 'd.id = a.device_id');
        $query = $this->db->get();

        return $query->result_array();
    }

}
