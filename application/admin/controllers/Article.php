<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CRUD_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->rules = array(
            'create' => array(
                array(
                    'field' => 'title',
                    'label' => '标题',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'intro_left',
                    'label' => '描述',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'intro_right',
                    'label' => '描述',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'photo',
                    'label' => '封面',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'image',
                    'label' => '多图',
                    'rules' => 'trim|required'
                )
            ),
            'edit' => array(
                array(
                    'field' => 'title',
                    'label' => '标题',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'intro_left',
                    'label' => '描述',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'intro_right',
                    'label' => '描述',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'photo',
                    'label' => '封面',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'image',
                    'label' => '多图',
                    'rules' => 'trim|required'
                )
            )
        );
    }
-
    public function index($page = 1)
    {
        $vdata['title'] = '文章管理';
        $limit = $this->page_limit;
        $this->input->get('limit', TRUE) and is_numeric($this->input->get('limit')) AND $limit = $this->input->get('limit');
        $order = $this->_index_orders();
        $where = $this->_index_where();
        $vdata['pages'] = $this->_pages(site_url($this->class . '/index/'), $limit, $where, 3);
        $list = $this->model->get_list($limit, $limit * ($page - 1), $order, $where);
        foreach ($list as &$item) {
            $upload = $this->db->where('id', $item['photo'])->select('url')->get('upload')->row_array();
            $item['photo'] = upload_file($upload['url']);
        }
        $vdata['list'] = $list;

        $this->_display($vdata);
    }

    protected function _vdata(&$vdata)
    {
        $this->load->model('tag_model', 'tag');
        $vdata['tag'] = $this->tag->get_all(['admin_id' => $_SESSION['mid']]);
    }

    protected function _create_data()
    {
        $data = $this->input->post();
        $data['admin_id'] = $_SESSION['mid'];
        $data['create_time'] = time();
        $data['tag'] = !empty($data['tag']) ? implode(',', $data['tag']) : '';
        $data['intro_left'] = str_replace("\n", "<br>", $data['intro_left']);
        $data['intro_right'] = str_replace("\n", "<br>", $data['intro_right']);
        $text = isset($data['text']) ? $data['text'] : '';
        $page = isset($data['page']) ? $data['page'] : '';
        if (!empty($text)) {
            unset($data['text']);
            unset($data['page']);
            $arr = [];
            foreach ($text as $k => $v) {
                $arr[] = ['page' => isset($page[$k]) ? intval($page[$k]) : 0, 'content' => $v];
            }
            $data['text'] = json_encode($arr);
        }
        return $data;
    }

    protected function _edit_data()
    {
        $data = $this->input->post();
        $data['update_time'] = time();
        $data['tag'] = !empty($data['tag']) ? implode(',', $data['tag']) : '';
        $data['intro_left'] = str_replace("\n", "<br>", $data['intro_left']);
        $data['intro_right'] = str_replace("\n", "<br>", $data['intro_right']);
        $text = isset($data['text']) ? $data['text'] : '';
        $page = isset($data['page']) ? $data['page'] : '';
        if (!empty($text)) {
            unset($data['text']);
            unset($data['page']);
            $arr = [];
            foreach ($text as $k => $v) {
                $arr[] = ['page' => isset($page[$k]) ? intval($page[$k]) : 0, 'content' => $v];
            }
            $data['text'] = json_encode($arr);
        } else {
            $data['text'] = '';
        }
        return $data;
    }

    protected function _index_orders()
    {
        return array('id' => 'desc');
    }

    protected function _index_where()
    {
        return ['admin_id' => $_SESSION['mid']];
    }
}