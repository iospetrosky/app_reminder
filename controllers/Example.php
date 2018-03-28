<?php
class Example extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_example');
        $this->m_example->timestamp();
//        $this->load->helper('url_helper');
    }


    public function index()  {
        // some default actions
        $this->load->view('intro');
        $this->load->view('v_timetest');
    }
    
    public function ajax()  {

    }

}