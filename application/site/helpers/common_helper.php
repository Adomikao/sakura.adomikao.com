<?php
if (!function_exists('static_file')) {
    function static_file($file, $addition = false)
    {
        if (empty($file)) {
            return '';
        }
        if (strrpos($file, '.js')) {
            $fileMin = str_replace('.js', '.min.js', $file);
            $type = 'js/';
        } else if (strrpos($file, '.css')) {
            $fileMin = str_replace('.css', '.min.css', $file);
            $type = 'css/';
        } else {
            $type = '';
            $fileMin = '';
        }

        $url = '';
        if (is_file(STATIC_PATH . $file)) {
            $url = STATIC_URL . $file;
        }

        if (!empty($type)) {
            if (file_exists(STATIC_PATH . $type . $file)) {
                $url = STATIC_URL . $type . $file;
            }
            if (defined('ENVIRONMENT') && ENVIRONMENT != "development") {
                if (file_exists(STATIC_PATH . $type . $fileMin)) {
                    $url = STATIC_URL . $type . $fileMin;
                }
                if (empty($url) && file_exists(STATIC_PATH . $file)) {
                    $url = STATIC_URL . $file;
                }
            }
        }

        if (empty($url)) {
            return '<!-- static file error: ' . $file . ' cannot find. --><script>console.error("cannot find `' . $file . '`!")</script>';
        } else {
            if (defined('STATIC_V') && STATIC_V) {
                $url .= '?v=' . STATIC_V;
            }
            /*            if (defined('ENVIRONMENT') and ENVIRONMENT == "development") {
                            $url .= '?t=' . time();
                        }*/
        }

        if ($addition === true) {
            return $url;
        } else {
            if ($type == 'js/') {
                return '<script src="' . $url . '" type="text/javascript" charset="utf-8"></script>';
            } else if ($type == 'css/') {
                $media = in_array($addition, array('screen', 'print')) ? $addition : 'screen';
                return '<link rel="stylesheet" href="' . $url . '" type="text/css" media="' . $media . '" charset="utf-8">';
            } else {
                return $url;
            }
        }
    }
}

if (!function_exists('return_json')) {
    function return_json($data = [], $status = 1, $msg = '')
    {
        echo json_encode(['data' => $data, 'status' => $status, 'msg' => $msg]);
        return true;
    }
}

if (!function_exists('is_mobile')) {
    function is_mobile($mobile)
    {
        if (preg_match('/^1[3456789]\d{9}$/', $mobile)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('is_email')) {
    function is_email($email)
    {
        if (preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $email)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('get_client_ip')) {
    function get_client_ip()
    {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (!empty($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        } else {
            $ip = '';
        }
        preg_match("/[\d\.]{7,15}/", $ip, $ips);
        $ip = isset($ips[0]) ? $ips[0] : 'unknown';
        unset($ips);
        return $ip;
    }
}

/**
 *  获取Hashids对象
 */
function obj_hashids($salt = 'adomikao', $length = 9, $alphabet = '')
{
    $CI = &get_instance();
    $CI->load->library('hashids');
    return new Hashids($salt, $length, $alphabet);
}

if (!function_exists('upload_file')) {
    function upload_file($url)
    {
        return UPLOAD_URL . $url;
    }
}


if (!function_exists('weibo_share')) {

    function weibo_share($url,$title,$pic){
        $url = "https://service.weibo.com/share/share.php?url=$url&title=$title&pic=$pic";
        return $url;
    }
}

if (!function_exists('qq_share')){
    function qq_share($url,$title,$pic,$summary){
        $url = "https://connect.qq.com/widget/shareqq/index.html?url=$url&title=$title&source=qqShare&pics=$pic&summary=$summary";
        return $url;
    }
}

if (!function_exists('qr_code')){
    function qr_code($url){
        $qr_code = 'https://www.zhihu.com/qrcode?url='.$url;
        return $qr_code;
    }

}