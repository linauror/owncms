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

    function clean_cache(){
        $cache_path = getcwd().'/'.config_item('cache_path');
        $files = glob($cache_path.'*');
        foreach ($files as $line) {
            unlink($line);
        }
        $this->User_mdl->userlog_add('【系统】删除文件缓存');
        admintip('成功删除文件缓存！');
    }
    
    // ------------------------------------------------------------------------
}

/* End of file index.php */
/* Location: ./application/controllers/admin/index.php */
