<?php

class Device_setpoint_log_model extends CI_Model{
    private $_table_name = 'device_setpoint_logs';

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

    public function get_list($order_by = "a.created_date", $condition = "DESC")
    {
        $this->db->select('d.device_name, a.id AS action_id, a.action_type, a.status');
        $this->db->from($this->_table_name . ' a');
        $this->db->join('devices d', 'd.id = a.device_id');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_latest_setpoint($row_device_id)
    {
        $this->db->where('row_device_id', $row_device_id);
        $this->db->order_by('log_time', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

}
