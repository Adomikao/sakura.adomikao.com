<?php

class Category_model extends CI_Model
{
    private $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = 'image_category';
    }

    public function getRow($where, $select = '*')
    {
        return $this->db->select($select)->where($where)->get($this->_model)->row_array();
    }

    public function countData($where)
    {
        return $this->db->where($where)->from($this->_model)->count_all_results();
    }

    public function getData($where, $select = '*')
    {
        return $this->db->select($select)->where($where)->get($this->_model)->result_array();
    }

    public function insertData($data)
    {
        if (empty($data)) return false;
        $this->db->insert($this->_model, $data);
        return $this->db->affected_rows();
    }

    public function updateData($data, $where)
    {
        if (empty($data) || empty($where)) return false;
        $this->db->where($where)->update($this->_model, $data);
        return $this->db->affected_rows();
    }
}