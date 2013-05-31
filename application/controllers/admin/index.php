<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview(2);
        $this->load->model('Category_mdl');
        $categorys = $this->Category_mdl->get_list();
    }

    // ------------------------------------------------------------------------

    /**
     * 后台首页
     * @link : index.php/admin/index.html
     * @param :
     * @return : 
     */
    public function index()
    {
        $this->load->view('admin/index');
    }
    
    // ------------------------------------------------------------------------
}

/* End of file index.php */
/* Location: ./application/controllers/admin/index.php */
