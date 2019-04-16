<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->rules = array(
            'edit' => array(
                array(
                    'field' => 'title',
                    'label' => '网站标题',
                    'rules' => 'trim|required'
                )
            )
        );
    }

    public function index($page = 0)
    {
        $info = $this->db->where('admin_id', $_SESSION['mid'])->get('index')->row_array();
        $this->form_validation->set_rules($this->_get_rule('edit'));
        if (is_post()) {
            $data = $this->input->post();
            $data['tag'] = !empty($data['tag']) ? implode(',', $data['tag']) : '';
            $name = isset($data['name']) ? $data['name'] : '';
            $url = isset($data['url']) ? $data['url'] : '';
            if (!empty($url)) {
                unset($data['name']);
                unset($data['url']);
                $arr = [];
                foreach ($url as $k => $v) {
                    $arr[] = ['name' => isset($name[$k]) ? $name[$k] : '', 'url' => $v];
                }
                $data['link'] = json_encode($arr);
            } else {
                $data['link'] = '';
            }
            if ($this->form_validation->run() == false) {
                $this->_display(['status' => 0, 'msg' => validation_errors(), 'it' => $info]);
            } else {
                if (empty($info)) {
                    $data['admin_id'] = $_SESSION['mid'];
                    $data['create_time'] = time();
                    $this->model->create($data);
                } else {
                    $data['update_time'] = time();
                    $this->model->update($data, 'id = ' . $data['id']);
                }
                $res['msg'] = '操作成功';
                $res['status'] = 1;
                $this->load->view('msg', $res);
            }
        } else {
            $this->_display(['it' => $info]);
        }
    }
}
