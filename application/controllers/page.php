<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function index($slug)
    {
        $this->load->model('Page_mdl');
        $page = $this->Page_mdl->get('*', $slug, 'slug', array('ishidden' => 0));
        if (!$page) show_error('此页面不存在');  
        $this->load->vars(array('current_nav' => 'page/'.$slug));
        
        $this->load->model('Friendlink_mdl');
        $this->load->model('Post_mdl');
        $this->load->model('Comment_mdl');
        
        $categorys= $this->Category_mdl->get_list();    
        $now = date('Y-m-d H:i:s');
        
        $html['page'] = $page;
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['categorys'] = $categorys;
        $html['user_info'] = $this->User_mdl->get('username,usermail,userurl,logedtime,group', $this->User_mdl->uid);
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => $now, 'orderby' => 'click DESC', 'onlylist' => true));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view($page['template'], $html);
        $this->output->cache(config_item('cache_time'));
    }
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */
