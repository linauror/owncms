<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function index()
    {   
        $q = $this->input->get('q', true);
        if (!$q) show_error('请输入关键词！');      
        $this->load->vars(array('current_nav' => 'index'));
        
        $this->load->model('Friendlink_mdl');
        $this->load->model('Post_mdl');
        $this->load->model('Comment_mdl');
        $this->load->model('Category_mdl');
        
        $categorys= $this->Category_mdl->get_list();
        $currpage = $this->input->get('page') ? $this->input->get('page') : 1;
        $this->load->library('pagination');
        $page['base_url'] = '?';
        $page['per_page'] = 20;
        
        $post_list = $this->Post_mdl->get_list(array('select' => 'id,category,title,slug,click,comment_count,comment_status,content,posttime,uid', 'ishidden' => 0, 'posttime' => true, 'limit' => $page['per_page'], 'page' => $currpage, 'title' => $q));
        
        $page['total_rows'] = $post_list['total'];
        $this->pagination->initialize($page);   
        
        $html['q'] = $q;
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['categorys'] = $categorys;
        $html['post_list'] = $post_list['list'];
        $html['pagination'] = $this->pagination->create_links();
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'id,category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => true, 'orderby' => 'click DESC', 'onlylist' => true));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view('search', $html);
    } 
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
