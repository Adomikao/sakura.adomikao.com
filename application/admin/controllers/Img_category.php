<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Img_category extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->rules = array(
            'create' => array(
                array(
                    'field' => 'title',
                    'label' => '分类名称',
                    'rules' => 'trim|required'
                )
            ),
            'edit' => array(
                array(
                    'field' => 'title',
                    'label' => '分类名称',
                    'rules' => 'trim|required'
                )
            ));
    }

    protected function _create_data()
    {
        $data = $this->input->post();
        $data['admin_id'] = $_SESSION['mid'];
        $data['create_time'] = time();
        return $data;
    }

    protected function _edit_data()
    {
        $data = $this->input->post();
        $data['update_time'] = time();
        return $data;
    }

    protected function _index_orders()
    {
        return array('id' => 'desc');
    }

    protected function _index_where()
    {
        return ['admin_id' => $_SESSION['mid'], 'is_delete' => 0];
    }
}
