<?php

class Device_model extends CI_Model{
    private $_table_name = 'devices';

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

    public function get_list($order_by = "dv.device_id", $condition = "ASC")
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

    public function get_list_by_room_id($room_id, $order_by = "dv.device_id", $condition = "ASC")
    {
        $this->db->select('dv.id AS row_device_id, dv.status AS device_status, dv.device_id, dv.room_id, dv.device_type_id, dv.device_name, dv.status, ro.room_name, zo.zone_name,
        fo.floor_name, dt.type_name, ds.state_name');
        $this->db->from($this->_table_name . ' dv');
        $this->db->where("room_id", $room_id);
        $this->db->join('rooms ro', 'ro.id = dv.room_id');
        $this->db->join('zones zo', 'zo.id = ro.zone_id');
        $this->db->join('floors fo', 'fo.id = zo.floor_id');
        $this->db->join('device_types dt', 'dt.id = dv.device_type_id');
        $this->db->join('device_states ds', 'ds.id = dt.state_id');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_list_by_state_id_and_room_id($state_id, $room_id, $order_by = "dv.device_id", $condition = "ASC")
    {
        $this->db->select('dv.id AS row_device_id, dv.status AS device_status, dv.device_id, dv.room_id, dv.device_type_id, dv.device_name, dv.status, ro.room_name, zo.zone_name,
        fo.floor_name, dt.type_name, ds.state_name');
        $this->db->from($this->_table_name . ' dv');
        $this->db->where("room_id", $room_id);
        $this->db->join('rooms ro', 'ro.id = dv.room_id');
        $this->db->join('zones zo', 'zo.id = ro.zone_id');
        $this->db->join('floors fo', 'fo.id = zo.floor_id');
        $this->db->join('device_types dt', 'dt.id = dv.device_type_id');
        $this->db->where("dt.state_id", $state_id);
        $this->db->join('device_states ds', 'ds.id = dt.state_id');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_list_by_state_id($state_id, $order_by = "dv.device_id", $condition = "ASC")
    {
        $this->db->select('dv.id AS row_device_id, dv.device_name');
        $this->db->from($this->_table_name . ' dv');
        $this->db->join('device_types dt', 'dt.id = dv.device_type_id');
        $this->db->where("dt.state_id", $state_id);
        $this->db->join('device_states ds', 'ds.id = dt.state_id');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_list_by_device_type_id($type_id, $order_by = "device_id", $condition = "ASC")
    {
        $this->db->select('id AS row_device_id, device_name');
        $this->db->from($this->_table_name);
        $this->db->where("device_type_id", $type_id);
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_row_id($id)
    {
        $this->db->select('d.*, t.type_name, t.type_short_name, s.state_name, v.min_value, v.max_value, u.unit_name');
        $this->db->from($this->_table_name . ' d');
        $this->db->join('device_types t', 'd.device_type_id = t.id');
        $this->db->join('device_states s', 's.id = t.state_id');
        $this->db->join('device_type_properties p', 'p.device_type_id = t.id', 'left');
        $this->db->join('device_property_values v', 'v.property_id = p.property_id', 'left');
        $this->db->join('units u', 'u.id = v.unit', 'left');
        $this->db->where("d.id", $id);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    public function get_by_device_id($id)
    {
        $this->db->where("device_id", $id);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    public function get_by_room_id($id)
    {
        $this->db->where("room_id", $id);
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    public function get_by_device_state($state_name, $order_by = 'd.device_name', $condition = ' ASC')
    {
        $this->db->select('d.id AS device_row_id, d.device_name');
        $this->db->from($this->_table_name . ' d');
        $this->db->join('device_types t', 't.id = d.device_type_id');
        $this->db->join('device_states s', 's.id = t.state_id');
        $this->db->where('s.state_name', $state_name);
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get();

        return $query->result_array();
    }
}
