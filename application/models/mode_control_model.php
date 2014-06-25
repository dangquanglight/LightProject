<?php

class Mode_control_model extends CI_Model{
    private $_table_name = 'mode_control';

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

    public function get_list($order_by = "mode_name", $condition = "ASC")
    {
        $this->db->select('*');
        $this->db->order_by($order_by, $condition);
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->_table_name);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function get_by_id($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    public function get_by_status($status)
    {
        $this->db->where("status", $status);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    public function get_not_in_by_id($array_id)
    {
        $this->db->where_not_in("id", $array_id);
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

}
