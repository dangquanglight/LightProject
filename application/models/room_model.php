<?php

class Room_model extends CI_Model{
    private $_table_name = 'rooms';

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

    public function get_list($order_by = "room_name", $condition = "ASC")
    {
        $this->db->select('id AS room_id, room_name');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    public function get_list_location($order_by = "fo.floor_name", $condition = "asc")
    {
        $this->db->select('fo.floor_name, fo.id AS floor_id, zo.zone_name, zo.id AS zone_id, ro.room_name, ro.id AS room_id');
        $this->db->from($this->_table_name . ' ro');
        $this->db->join('zones zo', 'zo.id = ro.zone_id');
        $this->db->join('floors fo', 'fo.id = zo.floor_id');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_zone_id($id, $order_by = "room_name", $condition = "ASC")
    {
        $this->db->select('id AS room_id, room_name');
        $this->db->where("zone_id", $id);
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

    public function get_floor_id($id)
    {
        $this->db->select('f.id as floor_id, f.floor_name');
        $this->db->from($this->_table_name . ' r');
        $this->db->where('r.id', $id);
        $this->db->join('zones z', 'z.id = r.zone_id');
        $this->db->join('floors f', 'f.id = z.floor_id');
        $query = $this->db->get();

        return $query->row_array();
    }

}
