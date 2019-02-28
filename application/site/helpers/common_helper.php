<?php
/**
 * Created by PhpStorm.
 * User: yuyongjian
 * Date: 2019/2/27
 * Time: 16:35
 */

if (!function_exists('static_file')){
    function static_file($file, $addition = false)
    {
        if (empty($file)) {
            return '';
        }
        if (strpos($file, '.js')){
            $fileMin = str_replace('.js','.min.js', $file);
            $type = 'js/';
        }elseif (strpos($file, '.css')){
            $fileMin = str_replace('.css', '.min.css', $file);
            $type = 'css/';
        }else{
            $fileMin = '';
            $type = '';
        }

        $url = '';
        if (is_file(STATIC_PATH . $file)){
            $url = STATIC_URL . $file;
        }

        if (!empty($type)){
            if (file_exists(STATIC_URL . $type . $file)){
                $url = STATIC_URL .$type .$file;
            }
            if (define('ENVIRONMENT') && ENVIRONMENT !== 'development'){
                if (file_exists(STATIC_URL . $type . $fileMin)){
                    $url = STATIC_URL . $type .$fileMin;
                }
                if (empty($url) && file_exists(STATIC_URL . $file)){
                    $url = STATIC_URL . $file;
                }
            }
        }

        if (empty($url)){
            return '<script>console.error("cannot find`'.$file.'`!")</script>';
        }else{
            if (defined('STATIC_V') && STATIC_V){
                $url .= '?v=' . STATIC_V;
            }
        }

        if ($addition === true){
            return $url;
        } else {
            if ($type == 'js/'){
                return '<script src="'.$url.'" type="text/javascript" charset="utf-8"></script>';
            } elseif ($type == 'css/'){
                $media = in_array($addition, array('screen', 'print')) ? $addition : 'screen';
                return '<link rel="stylesheet" href="' . $url . '" type="text/css" media="' . $media . '" charset="utf-8">';
            } else{
                return $url;
            }
        }
    }

}


if (!function_exists('upload_file')){
    function upload_file($url){
        return UPLOAD_URL . $url;
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