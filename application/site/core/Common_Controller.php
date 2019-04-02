<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_Controller extends CI_Controller
{
    public $seoTitle = 'Sakura | Adomikao';
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('uisite');
        $this->load->model('category_model', 'category');
        $this->load->model('image_model', 'image');
        
        ini_set('date.timezone','Asia/Shanghai');// 设置时区
        
        //隐藏X-Powered-By
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By'); // PHP 5.3+
        } else {
            @ini_set('expose_php', 'off');
        }


    }
}
