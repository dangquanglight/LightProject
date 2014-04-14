<?php

class Device_state_model extends CI_Model{
    private $_table_name = 'device_states';

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

    public function get_list($order_by = "device_id", $condition = "asc")
    {
        $this->db->select('dv.id AS row_device_id, dv.status AS device_status, dv.device_id, dv.room_id, dv.device_type_id, dv.device_name, dv.status, ro.room_name, zo.zone_name,
        fo.floor_name, dt.type_name, ds.state_name');
        $this->db->from($this->_table_name . ' dv');
        $this->db->join('rooms ro', 'ro.id = dv.room_id');
        $this->db->join('zones zo', 'zo.id = ro.zone_id');
        $this->db->join('floors fo', 'fo.id = zo.floor_id');
        $this->db->join('device_types dt', 'dt.id = dv.device_type_id');
        $this->db->join('device_states ds', 'ds.id = dt.state_id');
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

    public function get_by_name($state_name)
    {
        $this->db->where("state_name", $state_name);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

}
