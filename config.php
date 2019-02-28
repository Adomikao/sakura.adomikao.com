<?php
/**
 * Created by PhpStorm.
 * User: yuyongjian
 * Date: 2019/2/26
 * Time: 14:12
 */

//数据库
define('DB_TYPE','mysqli');
define('DB_HOST','127.0.0.1');
define('DB_USER','root');
define('DB_PASS','root');
define('DB_NAME','adomikao_wp209');
define('DB_PREFIX','qaq_');


//全局URL路径
define('GLOBAL_URL', 'qaq.sakura.com');
define('STATIC_URL', GLOBAL_URL . 'public/static/');
define('UPLOAD_URL', GLOBAL_URL . 'public/upload/');
define('IMG_URL',  STATIC_URL . 'img/');
define('ADMIN_IMG_URL', STATIC_URL . 'admin/img');



// 绝对路径PATH
define('ROOT', __DIR__ . '/');
define('CI_PATH', ROOT . 'system');
define('SITE_PATH', ROOT . 'application/site/');
define('STATIC_PATH', ROOT . 'public/static/');
define('UPLOAD_PATH', ROOT . 'public/upload');







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