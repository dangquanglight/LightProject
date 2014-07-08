<?php

class Floor_model extends CI_Model{
    private $_table_name = 'floors';

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

    public function get_list($order_by = "floor_name", $condition = "ASC")
    {
        $this->db->select('id AS floor_id, floor_name');
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

    public function get_by_building_id($id, $order_by = "floor_name", $condition = "ASC")
    {
        $this->db->select('id AS floor_id, floor_name');
        $this->db->where("building_id", $id);
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

}
