<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function index($category)
    {
        $this->load->model('Category_mdl');
        $thecategory = $this->Category_mdl->get('id, typename, tempindex', $category, 'slug');
        if (!$thecategory) show_error('此分类不存在');
        $this->load->vars(array('current_nav' => 'category/'.$category));
        $this->load->model('Friendlink_mdl');
        $this->load->model('Post_mdl');
        $this->load->model('Comment_mdl');
        
        $categorys= $this->Category_mdl->get_list();
        $currpage = $this->input->get('page') ? $this->input->get('page') : 1;
        $this->load->library('pagination');
        $page['base_url'] = '?';
        $page['per_page'] = 20;
        
        $post_list = $this->Post_mdl->get_list(array('select' => 'id,category,content,title,slug,click,comment_count,posttime,comment_status,uid', 'ishidden' => 0, 'limit' => $page['per_page'], 'posttime' => true, 'page' => $currpage, 'category' => $category));
        
        $page['total_rows'] = $post_list['total'];
        $this->pagination->initialize($page);        
        
        
        $html['thecategory'] = $thecategory;
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['categorys'] = $categorys;
        $html['post_list'] = $post_list['list'];
        $html['pagination'] = $this->pagination->create_links();
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => true, 'orderby' => 'click DESC', 'onlylist' => true));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view('category', $html);
        $this->output->cache(config_item('cache_time'));
    }
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */
