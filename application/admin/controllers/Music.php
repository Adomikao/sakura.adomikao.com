<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Music extends CRUD_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->rules = array(
            'create' => array(
                array(
                    'field' => 'music',
                    'label' => '曲名',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'intro',
                    'label' => '描述',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'download_url',
                    'label' => '音乐',
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

    public function index($page = 1)
    {
        $vdata['title'] = '文章管理';
        $limit = $this->page_limit;
        $this->input->get('limit', TRUE) and is_numeric($this->input->get('limit')) AND $limit = $this->input->get('limit');
        $order = $this->_index_orders();
        $where = $this->_index_where();
        $vdata['pages'] = $this->_pages(site_url($this->class . '/index/'), $limit, $where, 3);
        $list = $this->model->get_list($limit, $limit * ($page - 1), $order, $where);
        $vdata['list'] = $list;
        $this->_display($vdata);
    }

    public function upload()
    {
        set_time_limit(0);
        $date = 'music';
        $uploadPath = UPLOAD_PATH . $date;
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
            chmod($uploadPath, 0777);
        };
        $config['upload_path'] = $uploadPath . '/';
        $config['encrypt_name'] = false;
        $config['allowed_types'] = '*';
        $config['max_size'] = '102400';  //100M
        $this->load->library('upload');
        $this->upload->initialize($config);
        $fieldName = 'file';
        if (!empty($_FILES[$fieldName]['name'])) {
            if ($this->upload->do_upload($fieldName)) {
                $temp = $this->upload->data();
                $fileName = $temp['file_name'];
                $url = $date . '/' . $fileName;
                $result = [
                    'status' => 1,
                    'url' => upload_file($url),
                ];
                exit(json_encode($result));
            }
            $result = json_encode([
                'status' => 0,
                'msg' => $this->upload->display_errors()
            ]);
            exit($result);
        }
        $result = json_encode([
            'status' => 0,
            'msg' => '上传失败'
        ]);
        exit($result);
    }

    protected function _vdata(&$vdata)
    {
        $this->load->model('tag_model', 'tag');
        $vdata['tag'] = $this->tag->get_all(['admin_id' => $_SESSION['mid']]);
    }

    protected function _create_data()
    {
        $data = $this->input->post();
        $data['create_time'] = time();
        $data['intro'] = str_replace("\n", "<br>", $data['intro']);
        unset($data['file']);
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
        return [];
    }
}