<?php
/**
 * Created by PhpStorm.
 * User: yuyongjian
 * Date: 2019/2/27
 * Time: 11:24
 */
class Common_Controller extends CI_Controller
{
    public $seoTitle = 'QAQ | Adomikao';
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('uisite');
        $this->load->model('category_model', 'category');
        $this->load->model('image_model', 'image');

    }

}