<?php
/**
 * Created by PhpStorm.
 * User: yuyongjian
 * Date: 2019/2/27
 * Time: 17:49
 */

// 获取图片
if (!function_exists('tag_photo')) {
    function tag_photo($id, $column = 'url')
    {
        static $a = array();

        $id = intval($id);
        if (!isset($a[$id])) {

            $CI = &get_instance();
            $CI->load->database();
            $a[$id] = $CI->db->get_where('upload', array('id' => $id));
            if ($a[$id]->num_rows() < 1) {
                $a[$id] = array();
            } else {
                $a[$id] = $a[$id]->row_array();
            }
        }
        if (isset($a[$id][$column])) {
            return $a[$id][$column];
        }
        return '';
    }
}