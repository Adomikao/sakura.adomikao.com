<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// 建立空文件 为其它的对象进行引用

class Upload_model extends MY_Model
{
    protected $table = 'upload';

    /**
     * 获取id组内的数据
     * @param  string , $where_in ids
     * @return array
     */
    public function get_in($where_in = [])
    {
        if (empty($where_in)) {
            return [];
        }
        $this->db->where_in('id', $where_in);
        $query = $this->db->get('upload');
        return $query->result_array();
    }
}
