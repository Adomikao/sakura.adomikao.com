<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Login extends CI_Controll
 * @author era
 */
class Login extends Base_Controller
{
    public $uid;

    protected $rules = array(
        "login" => array(
            array(
                'field' => 'uname',
                'label' => '帐号',
                'rules' => 'trim|required|strtolower|callback_checkAccount'
            ),
            // 密码验证放在最后
            array(
                'field' => 'pwd',
                'label' => '密码',
                'rules' => 'trim|required|callback_checkPassword'
            )
        ),
        "getpass" => array(
            array(
                'field' => 'email'
            , 'label' => '邮箱帐号'
            , 'rules' => 'trim|required|strtolower|valid_email|callback_mailCheck'
            )
        )
    , "setpass" => array(
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

    public function index()
    {
        $vdata['title'] = '登录';
        $this->form_validation->set_rules($this->rules['login']);
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login', $vdata);
        } else {
            $mid = $this->uid;
            $info = $this->mmger->get_login($mid);
            $_SESSION['mid'] = $mid;
            $_SESSION['uname'] = $info['uname'];
            $_SESSION['nickname'] = $info['nickname'];
            $_SESSION['login_ip'] = get_ip();
            $_SESSION['gid'] = $info['gid'];
            $_SESSION['login_time'] = time();
            $this->mmger->set_login($mid);
            // 记住登录 1 周
            if ($this->input->post('remember')) {
                $rememberHours = $this->mcfg->get('adminer', 'rember_hours');
                if (!is_numeric($rememberHours)) {
                    $rememberHours = 72;
                }

                $_rember = md5(HMACPWD . $info['uname'] . $_SESSION['login_ip']);
                $cookie = array(
                    'name' => '_rember',
                    'value' => $_rember,
                    'expire' => 60 * 60 * $rememberHours,
                    'path' => $this->config->item('cookie_path'),
                );
                $cookie2 = array(
                    'name' => '_m',
                    'value' => $mid,
                    'expire' => 60 * 60 * $rememberHours,
                    'path' => $this->config->item('cookie_path'),
                );
                $this->input->set_cookie($cookie);
                $this->input->set_cookie($cookie2);
            }

            $this->mlogs->add('login', 'manager ID ' . $_SESSION['mid'] . ': 登录成功！');

            if ($this->input->get('url')) {
                redirect(urldecode($this->input->get('url')));
            } else {
                redirect(site_url('welcome'));
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        // 退出则清除记住登录
        delete_cookie('_m');
        delete_cookie('_rember');
        redirect(site_url('login'));
    }

    // 验证账号
    public function checkAccount($str = '')
    {
        if ($str and $mid = $this->mmger->find_name($str)) {
            $this->uid = $mid;
            return TRUE;
        } else {
            $this->form_validation->set_message('checkAccount', '这个 %s : ' . $str . ' 不存在。');
            $this->uid = '';
            return FALSE;
        }
    }

    // 验证密码
    public function checkPassword($pwd = '')
    
    {
    
        // 消除通过路由的请求
        if (!$pwd || $this->router->method == 'checkPassword') {
            show_404();
        }
        // 帐号存在则过
        if ($mid = $this->uid) {
            $info = $this->mmger->get_login($mid);
            // 获取禁用登录时间
            $forbidden_hours = $this->mcfg->get('adminer', 'forbidden_hours');
            if (!is_numeric($forbidden_hours)) {
                $forbidden_hours = 1;
            }

            if ($info['pwd_errors'] > 2) {
                if (time() - $info['login_time'] < 60 * 60 * $forbidden_hours) {
                    $this->form_validation->set_message('checkPassword', '怕是不知道密码吧  (●’◡’●)ﾉ ヾ(*´▽‘*)ﾉ</p>请于<b> ' . mdate("%Y/%m/%d %H:%i:%s", $info['login_time'] + 60 * 60 * $forbidden_hours) . ' </b>之后再尝试');
                    return FALSE;
                } else {
                    $this->mmger->set_pwderr($mid, true);
                }
            }
            if (passwd($pwd) != $info['pwd']) {
                $this->mmger->set_pwderr($mid);
                $this->form_validation->set_message('checkPassword', '密码有误,请重新登录！');
                return FALSE;
            }
            return TRUE;
        }

    }

    // 验证mail是否存在
    public function mailCheck($mail = FALSE)
    {
        if ($mail and $mid = $this->mmger->find_mail($mail)) {
            $this->mail = $mid;
            return TRUE;
        } else {
            $this->form_validation->set_message('mailCheck', '这个 %s : ' . $mail . ' 不存在。');
            $this->mail = FALSE;
            return FALSE;
        }
    }

    // 找回密码
    public function getpass()
    {

        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $vdata = array('status' => 0, 'msg' => 'email 不存在');
        $this->form_validation->set_rules($this->rules['getpass']);
        if ($this->form_validation->run() == FALSE) {
            $vdata['msg'] = validation_errors();
        } else {
            $time = time();
            $hash = passwd($time);
            $this->mmger->update(array('getpass' => $time), array('id' => $this->mail));
            $to = $this->form_validation->set_value('email');
            $link = site_url('login/setpass/' . $this->mail . '/' . $hash);
            $mail = array(
                'subject' => "BOC：找回密码"
            , 'message' => '点击下面的链接或者复制到浏览器地址栏，重新设置密码：<br/><a href="' . $link . '" target="_blank">' . $link . '</a>'
            , 'to' => $to
            );
            smtp_sendmail($mail);
            $vdata['status'] = 1;
            $vdata['msg'] = "去邮箱检查邮件，重新设置密码。";
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($vdata));
    }

    // 重新设置密码
    public function setpass($id, $getpass)
    {
        $gp = $this->mmger->get_one($id, 'getpass,nickname');
        $vdata['nickname'] = $gp['nickname'];
        $vdata['title'] = '密码修改';

        if ($this->_check($id, $getpass)) {
            $this->form_validation->set_rules($this->rules['setpass']);
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('login_setpass.php', $vdata);
            } else {
                $pwdre = $this->form_validation->set_value('pwdre');
                if ($this->mmger->set_pwd($id, passwd($pwdre))) {
                    $vdata['status'] = 1;
                    $vdata['msg'] = "成功修改密码!";
                    $vdata['title'] = '用户登录';
                    $this->load->view('login.php', $vdata);
                } else {
                    $vdata['status'] = 0;
                    $vdata['msg'] = "修改密码失败!";
                    $this->load->view('login_setpass.php', $vdata);
                }
            }
        } else {
            $vdata['title'] = '用户登录';
            $vdata['status'] = 0;
            $vdata['msg'] = "该链接已经失效!";
            $this->load->view('login.php', $vdata);
        }
    }

    // 检测密码重设链接有效性
    private function _check($id, $getpass)
    {
        $gp = $this->mmger->get_one($id, 'getpass');

        // 三十分钟超时
        if (time() - intval($gp['getpass']) > 30 * 60) {
            return FALSE;
        }

        if (passwd($gp['getpass']) == $getpass) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
