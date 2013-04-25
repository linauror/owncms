<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Siteconfig extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
        $this->load->vars(array('nav' => 'siteconfig'));
    }

    // ------------------------------------------------------------------------

    /**
     * Siteconfig::index()
     * 
     * @return void
     */
    public function index()
    {
        $siteconfig = $this->Siteconfig_mdl->get_list();
        $html['siteconfig'] = $siteconfig;
        $this->load->view('admin/siteconfig', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Siteconfig::add()
     * 增加变量
     * @return void
     */
    public function add() 
    {
        $post = $this->input->post();
        if (count(array_filter($post)) < 4) {
            admintip('error:请填写完整！');
        } elseif ($this->Siteconfig_mdl->add($post)) {
            $this->User_mdl->userlog_add('【网站设置】新增变量：' . $post['description'] . '[' . $post['varname'] . ']');
            admintip('成功新增变量！');
        } else {
            admintip('error:新增变量失败，变量名称重复！');
        }
    }

    // ------------------------------------------------------------------------
    
    /**
     * Siteconfig::del()
     * 删除变量
     * @param mixed $id
     * @return void
     */
    public function del($id) 
    {
        if ($this->Siteconfig_mdl->del($id)) {
            $this->User_mdl->userlog_add('【网站设置】删除变量：[' . $post['varname'] . ']');
            admintip('成功删除变量！');   
        }
        admintip('error:删除变量失败，不允许删除的变量！');  
    } 

    // ------------------------------------------------------------------------

    /**
     * Siteconfig::save()
     * 更新变量
     * @return void
     */
    public function save() 
    {
        $post = $this->input->post();
        $this->Siteconfig_mdl->update($post);
        $this->User_mdl->userlog_add('【网站设置】批量更新');
        admintip('成功更新变量！');
    }


}

/* End of file siteConfig.php */
/* Location: ./application/controllers/admin/siteConfig.php */
