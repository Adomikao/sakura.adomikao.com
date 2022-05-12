<?php
/**
 * Created by PhpStorm.
 * User: adomikao
 * Date: 2022/04/28
 * Time: 16:30
 */

# 数据库
define('DB_TYPE', 'mysqli');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '123456');
define('DB_NAME', 'adomikao_wp209');
define('DB_PREFIX', 'qaq_');

# 全局URL路径
define('GLOBAL_URL'  , 'http://'.$_SERVER['HTTP_HOST'].'/');
define('ADMINER_URL', GLOBAL_URL . 'moon/');
define('STATIC_URL', GLOBAL_URL . 'public/static/');
define('UPLOAD_URL', GLOBAL_URL . 'public/upload/');
define('IMG_URL', STATIC_URL . 'img/');
define('SAKURA_GITEE_URL','https://adomikao.gitee.io/media/sakura/');
define('GITHUB_CDN_URL', 'https://cdn.jsdelivr.net/gh/adomikao/CDN/sakura');
define('IS_GITEE',false);
define('IS_GITHUB',false);

# 引用绝对路径PATH定义
define('ROOT', __DIR__ . '/');
define('CI_PATH', ROOT . 'system');
define('STATIC_PATH', ROOT . 'public/static/');
define('UPLOAD_PATH', ROOT . 'public/upload/');
define('SITE_PATH', ROOT . 'application/site');
define('ADMIN_PATH', ROOT . 'application/admin');
# 可忽略 当css|js改变时替换本地缓存,将false 替换为 'v[1,2...]'
define('STATIC_V', 'v1');



define('HMACPWD', 'SA1S2D3F4G5H6J7K8L9');

//define('ENVIRONMENT', 'production');
define('ENVIRONMENT', 'development');

function autoLoader($class)
{
    if (strpos($class, 'CI_') !== 0) {
        if (file_exists(APPPATH . 'core/' . $class . '.php')) {
            @include_once(APPPATH . 'core/' . $class . '.php');
        }
    }
}
spl_autoload_register('autoLoader');