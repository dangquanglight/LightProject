<?php

class Building_model extends CI_Model{
    private $_table_name = 'buildings';

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

    public function get_list($order_by = "building_name", $condition = "ASC")
    {
        $this->db->select('id AS building_id, building_name');
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

    public function get_devices_list($id, $order_by = "d.device_id", $condition = "ASC")
    {
        $this->db->select('d.id AS row_device_id, d.status AS device_status, d.device_id, d.room_id, d.device_type_id,
        d.device_name, d.status, r.room_name, z.zone_name, f.floor_name, dt.type_name, dt.type_short_name, ds.state_name');
        $this->db->from($this->_table_name . ' b');
        $this->db->where('b.id', $id);
        $this->db->join('floors f', 'f.building_id = b.id');
        $this->db->join('zones z', 'z.floor_id = f.id');
        $this->db->join('rooms r', 'r.zone_id = z.id');
        $this->db->join('devices d', 'd.room_id = r.id');
        $this->db->join('device_types dt', 'dt.id = d.device_type_id');
        $this->db->join('device_states ds', 'ds.id = dt.state_id');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get();

        return $query->result_array();
    }

}
