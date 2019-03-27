<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Manager_model extends CI_Model
 * @author era
 */
class Manager_model extends MY_Model
{
    protected $table = 'manager';

    // 获得用户列表
    public function get_list($limit = 5, $start = 0, $order = false, $where = false, $fields = "*", $table = false, $like = '')
    {
        $this->db->select('manager.id,uname,nickname,status,login_today,login_time,g.title as groupname')
            ->from('manager')->join('manager_group as g', 'g.id=manager.gid')->limit($limit, $start);
        if ($order) {
            // 默认 ASC
            // 多个
            foreach ($order as $k => $v) {
                $this->db->order_by($k, $v);
            }
        } else {
            $this->db->order_by('id', 'desc');
        }
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_users()
    {
        $query = $this->db->select('id,nickname')->from('manager')->get();
        return $query->result_array();
    }

    // 获得群组
    public function get_groups()
    {
        $query = $this->db->select('id,title')->from('manager_group')->get();
        return $query->result_array();
    }

    // 返回 mid 所在的群组 gid
    public function get_gid($mid)
    {
        $query = $this->db->select('gid')->from('manager')->where("id", $mid)->get();
        if ($gid = $query->row_array()) {
            return $gid['gid'];
        }
        return FALSE;
    }

    // 检测帐号是否存在
    public function find_name($uname)
    {
        $data = $this->db->select('id')->where('uname', $uname)->get('manager')->row_array();
        if (empty($data)) return false;
        return $data['id'];
    }

    // 检测mail是否存在
    public function find_mail($email)
    {
        $data = $this->db->select('id')->where('email', $email)->get('manager')->row_array();
        if (empty($data)) return false;
        return $data['id'];
    }

    // 登录时提取数据
    public function get_login($id)
    {
        $query = $this->db->select('id,uname,nickname,gid,status,pwd,pwd_errors,login_time')->from('manager')->where('id', $id)->get();
        return $query->row_array();
    }

    // 密码输入错误 for login
    public function set_pwderr($id, $clear = FALSE)
    {
        if (!$clear) {
            $this->db->set('pwd_errors', 'pwd_errors+1', FALSE);
        } else {
            $this->db->set('pwd_errors', 0);
        }
        $this->db->set('login_ip', get_ip());
        $this->db->set('login_time', time());
        $this->db->where('id', $id);
        $this->db->update('manager');
        return $this->db->affected_rows();
    }

    // 登录成功后保存登录信息
    public function set_login($id)
    {
        $this->db->set('login_ip', get_ip());
        $this->db->set('login_time', time());
        $this->db->set('pwd_errors', 0);
        $this->db->where('id', $id);
        $this->db->update('manager');
        return $this->db->affected_rows();
    }

    public function get_group($gid)
    {
        $query = $this->db->select('title')->from('manager_group')->where('id', $gid)->get();
        return $query->row_array();
    }

    // 设置密码
    public function set_pwd($mid, $pwd)
    {
        $this->db->set('pwd', $pwd);
        $this->db->where('id', $mid);
        $this->db->update('manager');
        return $this->db->affected_rows();
    }
}
