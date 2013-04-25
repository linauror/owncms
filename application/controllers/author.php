<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Author extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function index($author = '')
    {   
        if (!$author) show_error('作者名字不能为空！');
        $user = $this->User_mdl->get('uid,usermail,username,userurl,regtime', $author, 'username');
        if (!$user) show_error('不存在的作者！');      
        $this->load->vars(array('current_nav' => 'index'));
        
        $this->load->model('Friendlink_mdl');
        $this->load->model('Post_mdl');
        $this->load->model('Comment_mdl');
        
        $categorys= $this->Category_mdl->get_list();
        $currpage = $this->input->get('page') ? $this->input->get('page') : 1;
        $this->load->library('pagination');
        $page['base_url'] = '?';
        $page['per_page'] = 20;
        
        $post_list = $this->Post_mdl->get_list(array('select' => 'id,category,title,slug,click,comment_count,comment_status,content,posttime,uid', 'ishidden' => 0, 'posttime' => true, 'limit' => $page['per_page'], 'page' => $currpage, 'uid' => $user['uid']));
        
        $page['total_rows'] = $post_list['total'];
        $this->pagination->initialize($page);   
        
        $html['user'] = $user;
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['categorys'] = $categorys;
        $html['post_list'] = $post_list;
        $html['pagination'] = $this->pagination->create_links();
        $html['user_info'] = $this->User_mdl->get('username,usermail,userurl,logedtime,group', $this->User_mdl->uid);
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => true, 'orderby' => 'click DESC', 'onlylist' => true));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view('author', $html);
        $this->output->cache(config_item('cache_time'));
    } 
}

/* End of file anthor.php */
/* Location: ./application/controllers/anthor.php */
