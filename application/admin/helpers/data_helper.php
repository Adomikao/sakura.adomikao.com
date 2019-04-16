<?php
// 主要放置数据操作的简化函数

if (!function_exists('list_upload')) {
    /**
     * 获取上传列表
     * @param  string $ids 上传列表值 '1,2,3[...]'
     * @return array|false 数组或逻辑false
     */
    function list_upload($ids)
    {
        if ($ids === false or !is_string($ids) or $ids == "") {
            return false;
        }
        $CI = &get_instance();
        $keys = explode(',', $ids);
        // 检测model
        if (!isset($CI->mupload)) {
            $CI->load->model('upload_model', 'mupload');
        }
        $tmp = $CI->mupload->get_in($keys);
        $list = $keys;
        foreach ($tmp as $v) {
            foreach ($keys as $k => $kid) {
                if ($kid == $v['id']) {
                    $list[$k] = $v;
                }
            }
        }
        foreach ($list as $key => $value) {
            if (!is_array($value)) {
                unset($list[$key]);
            }
        }
        return array_values($list);
    }
}

if (!function_exists('one_upload')) {
    /**
     * 获单个上传文件
     * @param  string $id 上传ID
     * @return array|false 数组或逻辑false
     */
    function one_upload($id)
    {
        if ($id === false or !is_numeric($id)) {
            return false;
        }
        $CI =& get_instance();
        // 检测model
        if (!isset($CI->mupload)) {
            $CI->load->model('upload_model', 'mupload');
        }
        return $CI->mupload->get_one($id);
    }
}

if (!function_exists('addScore')) {
    /*
     * 增加用户积分
     *
     * */
    function addScore($userId, $num)
    {
        $CI =& get_instance();
        $oldLevel = userLevel($userId);
        $userInfo = $CI->db->select('score,scoretotal')
            ->where('id', $userId)->get('user')->row_array();
        $update = array(
            'score' => $userInfo['score'] + $num,
            'scoretotal' => $userInfo['scoretotal'] + $num
        );
        $CI->db->where('id', $userId)->update('user', $update);
        //判断是否升级
        $nowLevel = userLevel($userId);
        //var_dump($oldLevel);var_dump($update);exit();
        if ($nowLevel['level'] > $oldLevel['level']) {
            writeLog($userId, '您已升到 ' . $nowLevel['level'] . ' 级,感谢您的参与。');
        }
        return true;
    }
}

function userLevel($userId)
{
    $CI =& get_instance();
    $now = $CI->db->select('scoretotal')
        ->where(array('id' => $userId))
        ->get('user')->row_array();
    $now = $now['scoretotal'];
    $array = array(
        array('level' => 1, 'min' => 0, 'max' => 9),
        array('level' => 2, 'min' => 10, 'max' => 29),
        array('level' => 3, 'min' => 30, 'max' => 99),
        array('level' => 4, 'min' => 100, 'max' => 299),
        array('level' => 5, 'min' => 300, 'max' => 1499),
        array('level' => 6, 'min' => 1500, 'max' => 4999),
        array('level' => 7, 'min' => 5000, 'max' => 19999),
        array('level' => 8, 'min' => 20000, 'max' => 99999),
        array('level' => 9, 'min' => 100000, 'max' => 100000000)
    );
    $array = levelSearch($now, $array);
    $data = $array[0];
    $data['nextlevel'] = $data['max'] + 1;
    $data['nowlevel'] = $data['min'];
    $data['now'] = $now;
    $data['rate'] = round((($now - $data['nowlevel']) / ($data['nextlevel'] - $data['nowlevel'])) * 100);
    unset($data['max']);
    unset($data['min']);
    return $data;
}

function levelSearch($score, $filter)
{
    $half = floor(count($filter) / 2); // 取出中間数
    // 判断积分在哪个区间
    if ($score <= $filter[$half - 1]['max']) {
        $filter = array_slice($filter, 0, $half);
    } else {
        $filter = array_slice($filter, $half, count($filter));
    }

    // 继续递归直到只剩一个元素
    if (count($filter) != 1) {
        $filter = levelSearch($score, $filter);
    }

    return $filter;
}

if (!function_exists('writeLog')) {
    /*
     * 增加用户消息
     *
     * */
    function writeLog($userId, $content, $forum = '')
    {
        $CI =& get_instance();
        $insert = array(
            'userid' => $userId,
            'timeline' => now(),
            'content' => $content,
            'forumid' => $forum
        );
        $CI->db->insert('mymessage', $insert);
        return true;
    }
}

if (!function_exists('typeName')) {
    /*
     * 增加用户消息
     *
     * */
    function typeName($id)
    {
        $CI =& get_instance();
        $where = array('id' => $id);
        $info = $CI->db->select('title')->where($where)->get('coltypes')->row_array();
        if (!isset($info['title'])) {
            $info['title'] = '';
        }
        return $info['title'];
    }
}

// TAG: UPDATE
if (!function_exists('list_coltypes')) {
    /**
     * 获取列表分类
     * @param  integer $cid 栏目ID
     * @param  integer $fid 分类查询顶级ID，默认为0
     * @param  string $name 字段名称，默认为ctype
     * @return array         多级别分类数组，历遍到底层
     */
    function list_coltypes($cid, $fid = 0, $name = 'ctype')
    {
        if (!is_numeric($cid) or $name === false) {
            return false;
        }
        $CI =& get_instance();
        // 检测model
        if (!isset($CI->mctypes)) {
            $CI->load->model('coltypes_model', 'mctypes');
        }
        return $CI->mctypes->get_tree($cid, $fid, $name);
        // return $CI->mctypes->get_ctypes_path($cid,$fid,$name);
    }
}

/**
 * 仅仅获取分类ID下的子分类，不向下寻找
 * @param  integer $cid 栏目ID
 * @param  integer $fid 分类查询顶级ID，默认为0
 * @param  string $name 字段名称，默认为ctype
 * @return array         当前父级别ID下的分类
 */
function list_coltypes_fid($cid, $fid = 0, $name = 'ctype')
{

    if (!is_numeric($cid) or $name === false) {
        return false;
    }
    $CI =& get_instance();
    // 检测model
    if (!isset($CI->mctypes)) {
        $CI->load->model('coltypes_model', 'mctypes');
    }
    return $CI->mctypes->get_ctypes($cid, $fid, $name);
}

/**
 * 获取fid下所有的子id ，为where提供in参数搜索
 * @param  integer $cid 栏目ID
 * @param  integer $fid 分类查询顶级ID，默认为0
 * @param  string $name 字段名称，默认为ctype
 * @return array         当前父级别ID下的分类
 */
function coltypes_ids($cid, $fid = 0, $name = 'ctype')
{

    if (!is_numeric($cid) or $name === false) {
        return false;
    }
    $CI =& get_instance();
    // 检测model
    if (!isset($CI->mctypes)) {
        $CI->load->model('coltypes_model', 'mctypes');
    }
    return $CI->mctypes->find_ids($cid, $fid, $name);
}

/**
 * 获取单个分类的信息
 * @param  boolean $id 分类ID
 * @param  string $fields 获取字段默认所有
 * @return array           栏目信息
 */
function one_ctype($id, $fields = "*")
{
    if (!is_numeric($id)) {
        return false;
    }
    $CI =& get_instance();
    // 检测model
    if (!isset($CI->mctypes)) {
        $CI->load->model('coltypes_model', 'mctypes');
    }
    return $CI->mctypes->get_one($id, $fields);
}

if (!function_exists('one_col')) {
    /**
     * 获取单个栏目基本信息
     * @param  integer $cid 栏目ID
     * @param  string $fields 获取字段默认所有
     * @return array           栏目信息
     */
    function one_col($cid, $fields = "*")
    {
        if ($cid === false or !is_numeric($cid)) {
            return false;
        }
        $CI =& get_instance();
        if (!isset($CI->mcol)) {
            $this->load->model('columns_Model', 'mcol');
        }
        return $CI->mcol->get_one($cid, $fields);
    }
}

if (!function_exists('get_list_cid')) {

    /**
     * 获取栏目下的列表（列表类型栏目）
     * @param  integer $cid 栏目ID
     * @param  integer $limit 获取条目
     * @param  array $where 条件
     * @param  string $fields 字段
     * @return array[]         列表数组
     */
    function get_list_cid($cid, $limit = 10, $where = false, $fields = '*')
    {
        if (!$cid) {
            return false;
        }
        $where = $where ? $where : array('cid' => $cid, 'audit' => 1);
        $CI =& get_instance();
        if (!isset($CI->mcol)) {
            $this->load->model('columns_Model', 'mcol');
        }
        $info = $CI->mcol->get_one($cid);
        $re_list = $CI->mcol->get_list($limit, 0, false, $where, $fields, $info['controller']);
        foreach ($re_list as $k => $v) {
            $re_list[$k]['path'] = $info['path'];
        }
        return $re_list;
    }
}

/**
 * 获取站点配置的分类下的某个键值的值
 * @param  string $category 分类
 * @param  string $key 键值
 * @return string / false
 */
function get_config_site($category, $key)
{
    $CI = &get_instance();
    if (!isset($CI->mcfg)) {
        $CI->load->model('configs_model', 'mcfg');
    }
    return $CI->mcfg->get_config($category, $key);
}
