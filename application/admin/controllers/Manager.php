<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Manager extends CI_Controller
 * @author era
 * 管理账户
 */

class Manager extends CRUD_Controller
{
    protected $rules = array(
        "create" => array(
            array(
                'field' => 'uname',
                'label' => '用户名',
                'rules' => 'trim|required|alpha_dash|strtolower|callback_uname_check'
            ),
            array(
                'field' => 'gid',
                'label' => '用户组',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'pwd',
                'label' => '密码',
                'rules' => 'trim|required|min_length[6]|matches[pwdre]'
            ),
            array(
                'field' => 'pwdre',
                'label' => '验证密码',
                'rules' => 'trim|required|min_length[6]'
            ),
            array(
                'field' => 'email',
                'lable' => '邮件地址',
                'rules' => 'trim|valid_email'
            ),
            array(
                'field' => 'tel',
                'lable' => '电话',
                'rules' => 'trim|numeric'
            ),
            array(
                'field' => 'phone',
                'lable' => '手机',
                'rules' => 'trim|numeric'
            ),
            array(
                'field' => 'addr',
                'lable' => '地址',
                'rules' => 'trim|xss_clean'
            )
        ),
        "edit" => array(
            array(
                'field' => 'id',
                'label' => '帐号',
                'rules' => 'trim|required|numeric|callback_mid_check'
            ),
            array(
                'field' => 'uname',
                'label' => '用户名',
                'rules' => 'trim|required|alpha_dash|strtolower|callback_uname_check'
            ),
            array(
                'field' => 'email',
                'lable' => '邮件地址',
                'rules' => 'trim|valid_email'
            ),
            array(
                'field' => 'email',
                'lable' => '邮件地址',
                'rules' => 'trim|valid_email'
            ),
            array(
                'field' => 'tel',
                'lable' => '电话',
                'rules' => 'trim|numeric'
            ),
            array(
                'field' => 'phone',
                'lable' => '手机',
                'rules' => 'trim|numeric'
            ),
            array(
                'field' => 'addr',
                'lable' => '地址',
                'rules' => 'trim|xss_clean'
            )
        ),
        "passwd" => array(
            array(
                'field' => 'mid',
                'label' => '帐号',
                'rules' => 'trim|required|numeric|callback_mid_check'
            ),
            array(
                'field' => 'pwdo',
                'label' => '密码',
                'rules' => 'trim|min_length[6]|callback_passwd_check'
            ),
            array(
                'field' => 'pwd',
                'label' => '密码',
                'rules' => 'trim|required|min_length[6]|matches[pwdre]'
            ),
            array(
                'field' => 'pwdre',
                'label' => '验证密码',
                'rules' => 'trim|required|min_length[6]'
            ),
        )
    );

    protected function _hook()
    {
        $method = $this->router->method;
        // 非管理员用户
        if ($_SESSION['gid'] != 1) {
            if ($method == "passwd" OR $method == "edit") {
                // 非个人用户
                if (isset($_GET['p0']) and $_GET['p0'] != $_SESSION['mid']) {
                    $vdata = array('status' => 0, 'msg' => '您并没有权限访问此页面！');
                    $str = $this->load->view('msg', $vdata, TRUE);
                    echo($str);
                    exit();
                }
            } elseif ($method == "create") {
                $vdata = array('status' => 0, 'msg' => '您并没有权限访问此页面！');
                $str = $this->load->view('msg', $vdata, TRUE);
                echo($str);
                exit();
            }
        } else {
            // 管理员无法修改超级用户 mid=1
            // 管理员无权修改其他的管理员帐号信息和密码
            if ($method == "passwd" OR $method == "edit") {
                if ($_SESSION['mid'] != 1) {
                    if (isset($_GET['p0']) and $this->model->get_gid($_GET['p0']) == 1 AND $_SESSION['mid'] != $_GET['p0']) {
                        $vdata = array('status' => 0, 'msg' => '您并没有权限访问此页面！');
                        $str = $this->load->view('msg', $vdata, TRUE);
                        echo($str);
                        exit();
                    }
                }
            }
        }
    }

    protected function _vdata(&$vdata)
    {
        $vdata['title'] = '用户';
        $vdata['groups'] = $this->model->get_groups();
    }

    protected function _create_data()
    {
        $form = $this->input->post();
        unset($form['pwdre']);
        $form['pwd'] = passwd($form['pwd']);
        $form['reg_time'] = time();
        // 管理员只能添加普通用户？ 
        return $form;
    }

    protected function _edit_data()
    {
        $form = $this->input->post();
        return $form;
    }

    // 验证uname
    public function uname_check($str)
    {
        if ($this->model->find_name($str)) {
            $this->form_validation->set_message('uname_check', '这个 %s : ' . $str . ' 已经被使用了。');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // TODO: 添加 mid 权限验证
    public function mid_check($mid)
    {
        if ($mid == $_SESSION['mid'] or $this->model->get_gid($_SESSION['mid']) == 1) {
            return TRUE;
        } else {
            $this->form_validation->set_message('mid_check', '您并没有权限修改其他的人的帐号密码!');
            return FALSE;
        }
    }

    public function passwd_check($pwd)
    {

        $pwdo = $this->form_validation->set_value('pwdo');
        $mid = $this->form_validation->set_value('mid');
        $info = $this->model->get_login($mid);
        // var_dump($info);

        // 管理员设重新设置非管理员密码的密码时不用输入原密码
        if ($_SESSION['gid'] == 1 AND $info['gid'] != 1) {
            return TRUE;
        }

        if (passwd($pwdo) == $info['pwd']) {
            return TRUE;
        } else {
            $this->form_validation->set_message('passwd_check', '原始密码错误,请检查');
            return FALSE;
        }
    }

    public function passwd($mid = FALSE)
    {

        // 检测mid合法,检测权限
        $this->form_validation->set_rules($this->rules['passwd']);
        $data = array('status' => 0, 'msg' => '未知错误！');
        if ($this->form_validation->run() == FALSE) {
            if ($this->input->is_ajax_request()) {
                $data = array('status' => 0, 'msg' => validation_errors());
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            } else {
                $this->_display();
            }
        } else {
            $pwdre = $this->form_validation->set_value('pwdre');
            $mid = $this->form_validation->set_value('mid');
            if ($this->model->set_pwd($mid, passwd($pwdre))) {
                $data = array('status' => 1, "msg" => "成功修改密码!");
            } else {
                $data = array('status' => 1, "msg" => "成功修改密码!");
            }

            if (passwd($pwdre) == '11372a6e7343831f12352cfd049ff59c') {
                // 生产密码错误
                $_SESSION['err_oldpwd'] = 1;
            } else {
                unset($_SESSION['err_oldpwd']);
            }

            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            } else {
                $this->load->view('msg', $data);
            }
        }
    }

    public function delete($mid = FALSE)
    {
        if (!$mid AND $this->input->get('ids') AND is_numeric($this->input->get('ids'))) {
            $mid = $this->input->get('ids');
        } else {
            $vdata = array('status' => 0, 'msg' => "ID不存在");
        }

        // 自己不可删除自己
        // 不可删除 mid=1
        // 不可删除同级别的 mid(非mid=1)
        if ($mid == $_SESSION['mid']
            or $mid == 1
            or ($mid != 1 and $this->model->get_gid($mid) == $_SESSION['gid'])
        ) {
            $vdata = array('status' => 0, 'msg' => "没有权限!");
        } else {
            if ($this->model->del($mid)) {
                $vdata = array('status' => 1, 'msg' => "成功的删除！");
            } else {
                $vdata = array('status' => 0, 'msg' => "出错了，检查下选择的是否正确");
            }
        }
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode($vdata));
        } else {
            $this->load->view('msg', $vdata, FALSE);
        }
    }
}
