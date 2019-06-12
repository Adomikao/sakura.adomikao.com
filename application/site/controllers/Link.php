<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Link extends Common_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $url = $this->input->get('url');
        if (empty($url)) {
            show_404();
        } else {
            redirect($url);
        }
    }
}