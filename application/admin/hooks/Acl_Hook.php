<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acl_Hook
{
    private $CI;
    private $url_model;  // 当前模型
    private $url_method; // 当前方法

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->url_model = $this->CI->router->class;
        $this->url_method = $this->CI->router->method;
    }

    // hook
    public function auth()
    {
        $urlParam = urlencode(empty($_SERVER['QUERY_STRING']) ? current_url() : current_url() . '?' . $_SERVER['QUERY_STRING']);
        if (empty($this->CI->session->gid)) {  //未登录
            //检测cookie
            if ($this->CI->input->cookie('_rember') and $this->CI->input->cookie('_m')) {
                if (!$this->_cookie_login()) {
                    if ($this->CI->input->is_ajax_request()) {
                        header('HTTP/1.1 500 Internal Server Error');
                        json_echo(array('status' => 0, 'msg' => '您的登陆已经失效，请重新登陆'));
                        return false;
                    } else {
                        redirect(site_url('login'));
                    }
                } else {
                    $url = $this->CI->input->get('url') ? urldecode($this->CI->input->get('url')) : site_url('welcome');
                    redirect($url);
                }
            } else {
                if ($this->url_model != 'login') {
                    if ($this->CI->input->is_ajax_request()) {
                        header('HTTP/1.1 500 Internal Server Error');
                        json_echo(array('status' => 0, 'msg' => 'err:02 您的登陆已经失效，请重新登陆'));
                        return false;
                    } else {
                        redirect(site_url('login'));
                    }
                }
            }
        } else {  // 已登录
            if ($this->url_model == 'login' and $this->url_method != "logout") {
                $url = $this->CI->input->get('url') ? $this->CI->input->get('url') : 'welcome';
                redirect(site_url($url));
            } else if ($this->url_model != 'login' and $this->CI->session->err_oldpwd and $this->url_model != 'manager' and $this->url_method != "passwd") {
                // 没有修改密码跳转修改
                redirect(site_url('manager/passwd'));
            }
        }
    }

    // 返回 bool 是否拥有权限
    public function _purview()
    {
        // 过滤器，过滤控制器
        $nopurview = $this->CI->mcfg->get('adminer', 'nopurview');

        if (in_array($this->url_model, explode(',', $nopurview))) {
            return TRUE;
        }

        if (!$this->CI->input->get('c')) {
            $pur = md5($this->url_model . '/' . $this->url_method);
        } else {
            $pur = md5($this->url_model . '/' . $this->url_method . '/' . $this->CI->input->get('c'));
        }

        // 过滤没有添加权限的uri
        if (!$this->CI->mpur->get_uri($pur)) {
            return TRUE;
        }

        // 过滤disable 不保护的权限
        $uris_disable = $this->CI->mpur->get_disable_list();
        if (in_array($pur, $uris_disable)) {
            return TRUE;
        }

        $group = $this->CI->mmger->get_group($this->CI->session->gid);
        if (in_array($pur, explode(',', $group['purview']))) {
            return TRUE;
        }

        if ($this->CI->session->gid == 1) {
            return TRUE;
        }

        return false;
    }

    // 对 cookie 记住登录的验证
    public function _cookie_login()
    {
        if (is_numeric($this->CI->input->cookie('_m'))) {
            $mid = $this->CI->input->cookie('_m');
        } else {
            return false;
        }
        $info = $this->CI->mmger->get_login($mid);
        if (!$info) {
            return false;
        }
        if (md5(HMACPWD . $info['uname'] . get_ip()) == $this->CI->input->cookie('_rember')) {
            $_SESSION['mid'] = $mid;
            $_SESSION['uname'] = $info['uname'];
            $_SESSION['nickname'] = $info['nickname'];
            $_SESSION['login_ip'] = get_ip();
            $_SESSION['gid'] = $info['gid'];
            $_SESSION['login_time'] = time();
            $this->CI->mmger->set_login($mid);
            return true;
        }
        return false;
    }
}