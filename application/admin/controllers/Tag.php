<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CRUD_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->rules = array(
			'create' => array(
				array(
					'field' => 'title',
					'label' => lang('title'),
					'rules' => 'trim|required'
				)
				,array(
					'field' => 'timeline',
					'label' => lang('time'),
					'rules' => 'trim|strtotime'
				)
            ),
            'edit' => array(
                array(
                    'field' => 'title',
                    'label' => lang('title'),
                    'rules' => 'trim|required'
                )
            ,array(
                    'field' => 'timeline',
                    'label' => lang('time'),
                    'rules' => 'trim|strtotime'
                )
            )
		);
	}

    protected function _create_data()
    {
        $data = $this->input->post();
        $data['admin_id'] = $_SESSION['mid'];
        $data['create_time'] = time();
        return $data;
    }

    protected function _index_orders()
    {
        return array('id' => 'desc');
    }

    protected function _index_where()
    {
        return ['admin_id' => $_SESSION['mid']];
    }
}
