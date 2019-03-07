<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Image extends CRUD_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->rules = array(
            'create' => array(
                array(
                    'field' => 'cid',
                    'label' => '分类',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'url',
                    'label' => '图片',
                    'rules' => 'trim|required'
                ),
            ),
            'edit' => array(
                array(
                    'field' => 'cid',
                    'label' => '分类',
                    'rules' => 'trim|required'
                )
            )
        );
    }

    public function index($page = 1)
    {
        $vdata['title'] = '图片管理';
        $limit = $this->page_limit;
        $this->input->get('limit', TRUE) and is_numeric($this->input->get('limit')) AND $limit = $this->input->get('limit');
        $order = $this->_index_orders();
        $where = $this->_index_where();
        $vdata['pages'] = $this->_pages(site_url($this->class . '/index/'), $limit, $where, 3);
        $list = $this->model->get_list($limit, $limit * ($page - 1), $order, $where);
        foreach ($list as &$item) {
            $upload = $this->db->where('id', $item['url'])->select('url')->get('upload')->row_array();
            $item['url'] = upload_file($upload['url']);
            $category= $this->db->where('id', $item['cid'])->select('title')->get('image_category')->row_array();
            $item['category'] = $category['title'];
        }
        $vdata['list'] = $list;
        $this->_display($vdata);
    }

    protected function _vdata(&$vdata)
    {
        $this->load->model('img_category_model', 'category');
        $vdata['category'] = $this->category->get_all(['admin_id' => $_SESSION['mid']]);
    }

    protected function _create_data()
    {
        $data = $this->input->post();
        $data['admin_id'] = $_SESSION['mid'];
        $data['create_time'] = time();
        return $data;
    }

    protected function _edit_data()
    {
        $data = $this->input->post();
        $data['update_time'] = time();
        return $data;
    }

    protected function _index_orders()
    {
        return array('id' => 'desc');
    }

    protected function _index_where()
    {
        return ['admin_id' => $_SESSION['mid'], 'is_delete' => 0];
    }
}