<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tag extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Post_mdl');
    }

    /**
     * 首页
     */
    public function index($tag = '')
    {
        $tag = urldecode($tag);        
        $tagid = $this->Post_mdl->get_tagid_by_tag($tag);
        if (!$tagid) show_error('此标签不存在');
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
        
        $post_list = $this->Post_mdl->get_list(array('select' => 'id,category,title,slug,click,comment_count,comment_status,content,posttime,uid', 'ishidden' => 0, 'posttime' => true, 'tag' => $tagid, 'limit' => $page['per_page'], 'page' => $currpage));
        
        $page['total_rows'] = $post_list['total'];
        $this->pagination->initialize($page);   
        
        $html['tag'] = $tag;
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['categorys'] = $categorys;
        $html['post_list'] = $post_list['list'];
        $html['pagination'] = $this->pagination->create_links();
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'id,category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => true, 'orderby' => 'click DESC'));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view('tag', $html);
        $this->output->cache(config_item('cache_time'));
    }
}

/* End of file tag.php */
/* Location: ./application/controllers/tag.php */
