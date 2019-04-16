<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$hook['post_controller_constructor'] = array(
    'class' => 'Acl_Hook',
    'function' => 'auth',
    'filename' => 'Acl_Hook.php',
    'filepath' => 'hooks'
);
