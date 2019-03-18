<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class My_model_controller extends CRUD_Controller
 * Module 对 cid 变化进行
 * @author
 */
class Modules_Controller extends CRUD_Controller
{
    public $cid = null;
    public $ccid = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function index($cid = false, $page = 1)
    {
        $limit = $this->page_limit;
        $this->input->get('limit', TRUE) and is_numeric($this->input->get('limit')) AND $limit = $this->input->get('limit');
        $order = $this->_index_orders();
        if ($this->input->get('order', TRUE)) {
            $order = $this->input->get('order', TRUE);
        }
        $where = $this->_index_where();
        $vdata['pages'] = $this->_pages(site_url($this->class . '/index/'), $limit, $where, 4);
        $vdata['list'] = $this->model->get_list($limit, $limit * ($page - 1), $order, $where);
        $this->_display($vdata);
    }

    // 带有条件查询的
    // 此处模式添加了ctype支持，如果需要多查询条件，定义私有函数
    protected function _index_where()
    {
        $arr = array();
        if (isset($_GET['ctype'])) {
            $arr['ctype'] = $_GET['ctype'];
        }
        return $arr;
    }

    // 此处返回数组
    protected function _index_orders()
    {
        return array('sort_id' => 'desc');
    }

    // 追加 cid 默认的规则验证
    protected function _get_rule($rule)
    {
        $rule = parent::_get_rule($rule);
        $rule_cid = array(
            'field' => 'cid',
            'label' => lang('modules_cid_change'),
            'rules' => 'required|numeric|callback_checkcid'
        );
        array_push($rule, $rule_cid);
        return $rule;
    }

    // 验证规则 验证CID合法
    public function checkcid()
    {
        if ($this->input->post('cid') AND $this->input->post('cid') == $this->input->get('c')) {
            return TRUE;
        } else {
            $this->form_validation->set_message('checkcid', lang("modules_cid_data_change_re"));
            return FALSE;
        }
    }

    /**
     * @brief 添加结束后的处理
     */
    protected function _create_after($data)
    {
        //  创建时生成链接
        // 保存关键词
        // 处理关键词，标题关键词，简介关键词，内容关键词
        if (isset($data['tags'])) {
            !!$data['tags'] and $this->mtags->add(str_replace(array('，', ' ', '　', '|'), ',', $data['tags']), $this->cid, $data['id']);
        }
    }

    /**
     * @brief 编辑结束后的处理
     */
    protected function _edit_after($data)
    {
        // 保存关键词
        // 处理关键词，标题关键词，简介关键词，内容关键词
        if (isset($data['tags'])) {
            !!$data['tags'] and $this->mtags->add(str_replace(array('，', ' ', '　', '|'), ',', $data['tags']), $this->cid, $data['id']);
        }
    }

    /**
     * @brief 删除
     * @param $key 键值 默认id
     * @return
     */
    public function delete($key = FALSE)
    {
        if (!$key AND $this->input->get('ids')) {
            $key = explode(',', $this->input->get('ids'));
        } else {
            $vdata = array('status' => 0, 'msg' => lang('modules_no_id'));
        }
        $where = FALSE;
        if ($this->input->get('c')) {
            $where = array('cid' => $this->input->get('c'));
        } else {
            $vdata = array('status' => 0, 'msg' => lang('modules_no_colid'));
        }

        if (!isset($vdata['status'])) {
            // 附带文件删除
            $this->_rm_file($key);

            if ($where) {
                $res = $this->model->del($key, $where);
            } else {
                $res = $this->model->del($key);
            }
            if ($res) {
                $vdata = array('status' => 1, 'msg' => lang('modules_del_ok'));
                // 日志记录
                if (is_array($key)) {
                    $this->mlogs->add('delete', lang('modules_del_id') . $this->input->get('ids'));
                } else {
                    $this->mlogs->add('delete', lang('modules_del_id') . $key);
                }
            } else {
                $vdata = array('status' => 0, 'msg' => lang('modules_del_err_select'));
            }
        }

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode($vdata));
        } else {
            $this->load->view('msg', $vdata);
        }
    }

    // 搜索
    public function search($cid = 0, $page = 1)
    {
        $limit = $this->page_limit;
        $this->input->get('limit', TRUE) and is_numeric($this->input->get('limit')) AND $limit = $this->input->get('limit');
        $order = $this->input->get('order', TRUE) ? $this->input->get('order', TRUE) : FALSE;
        $where = array();
        $where['cid'] = $this->cid;
        if ($ctype = $this->input->get('ctype', TRUE) AND is_numeric($ctype)) {
            $ctypes_ids = $this->mctypes->find_ids($this->cid, $ctype);
            $where['ctype'] = $ctypes_ids;
        }
        if ($this->input->get('q', TRUE)) {
            $where_q = array(
                'like title' => array('title', $this->input->get('q', TRUE))
            );
            $where = array_merge($where, $where_q);
        }
        $vdata['pages'] = $this->_pages(site_url($this->class . '/search/' . $this->cid . '/'), $limit, $where, 4);
        $vdata['list'] = $this->model->get_list($limit, $limit * ($page - 1), $order, $where);
        $this->_display($vdata, $this->class . '_index.php');
    }

    // 审核 POST (对于开关类型字段，拷贝审核修改相应的audit字段即可使用)
    public function audit($key = FALSE)
    {
        if (!$key AND $this->input->post('ids')) {
            $key = explode(',', $this->input->post('ids'));
        } else {
            $vdata = array('status' => 0, 'msg' => lang('modules_no_id'));
        }

        $where = FALSE;

        if ($this->input->get('c')) {
            $where = array('cid' => $this->input->get('c'));
        } else {
            $vdata = array('status' => 0, 'msg' => lang('modules_no_col_id'));
        }

        $audit = $this->input->post('audit');

        if ($audit) {
            $audit = 1;
        } else {
            $audit = 0;
        }
        $msg = array(lang('modules_audit_false'), lang('modules_audit_true'));

        if (!isset($vdata['status'])) {
            if ($where) {
                $res = $this->model->audit($audit, $key, $where);
            } else {
                $res = $this->model->audit($audit, $key);
            }
            if ($res) {
                $vdata = array('status' => 1, 'msg' => $msg[$audit]);
                if (is_array($key)) {
                    $this->mlogs->add('audit', lang('modules_audit_id') . $this->input->post('ids') . lang('modules_audit_for') . $audit);
                } else {
                    $this->mlogs->add('audit', lang('modules_audit_id') . $key . lang('modules_audit_for') . $audit);
                }
            } else {
                $vdata = array('status' => 0, 'msg' => lang('modules_audit_err_select'));
            }
        }
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode($vdata));
        } else {
            $this->load->view('msg', $vdata);
        }
    }

    // TODO:功能
    // 推荐 flag
    public function flag($key = FALSE)
    {
        if (!$key AND $this->input->post('ids')) {
            $key = explode(',', $this->input->post('ids'));
        } else {
            $vdata = array('status' => 0, 'msg' => lang('modules_no_id'));
        }
        $where = FALSE;
        if ($this->input->get('c')) {
            $where = array('cid' => $this->input->get('c'));
        } else {
            $vdata = array('status' => 0, 'msg' => lang('modules_no_col_id'));
        }
        $flag = $this->input->post('flag');
        if ($flag) {
            $flag = 1;
        } else {
            $flag = 0;
        }
        $msg = array(lang('modules_flag_false'), lang('modules_flag_true'));
        if (!isset($vdata['status'])) {
            if ($where) {
                $res = $this->model->flag($flag, $key, $where);
            } else {
                $res = $this->model->flag($flag, $key);
            }
            if ($res) {
                $vdata = array('status' => 1, 'msg' => $msg[$flag]);
                if (is_array($key)) {
                    $this->mlogs->add('flag', lang('modules_flag_id') . $this->input->post('ids') . lang('modules_flag_for') . $flag);
                } else {
                    $this->mlogs->add('flag', lang('modules_flag_id') . $key . lang('modules_flag_for') . $flag);
                }
            } else {
                $vdata = array('status' => 0, 'msg' => lang('modules_flag_err_select'));
            }
        }
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode($vdata));
        } else {
            $this->load->view('msg', $vdata);
        }
    }

}

// 用于替换 site_urlc 为其添加 ?c=
function site_urlc($uri = '')
{
    $CI =& get_instance();
    if ($CI->ccid) {
        $url = $CI->config->site_url($uri . "?c=" . $CI->cid . "&cc=" . $CI->ccid);
    } else {
        $url = $CI->config->site_url($uri . "?c=" . $CI->cid);
    }
    // 支持ctype
    if ($ctype = $CI->input->get('ctype')) {
        $url .= "&ctype=" . $ctype;
    }
    return $url;
}

// 用于替换 current_url
function current_urlc()
{
    $CI =& get_instance();
    if ($CI->ccid) {
        $url = $CI->config->site_url($CI->uri->uri_string() . "?c=" . $CI->cid . "&cc=" . $CI->ccid);
    } else {
        $url = $CI->config->site_url($CI->uri->uri_string() . "?c=" . $CI->cid);
    }
    // 支持ctype
    if ($ctype = $CI->input->get('ctype')) {
        $url .= "&ctype=" . $ctype;
    }
    return $url;
}