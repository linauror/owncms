<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Post extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview(2);
        $this->load->model('Post_mdl');
        $this->load->model('Category_mdl');
        $this->load->vars(array('nav' => 'post'));
    }

    // ------------------------------------------------------------------------
    
    /**
     * Post::index()
     * 文章首页
     * @return void
     */
    public function index()
    {
        $http_query = $this->input->get();        
        $post = $this->Post_mdl->get_list($http_query);
    
        //分页
        $this->load->library('pagination');
        unset($http_query['page']);
        $page['base_url'] = '?'.($http_query ? http_build_query($http_query) : '');
        $page['total_rows'] = $post['total'];
        $page['per_page'] = 20;
        $this->pagination->initialize($page);
        
        //分类目录
        $categorys = $this->Category_mdl->get_list();
        
        //标签
        $tags = array();
        foreach ($post['list'] as $line) {
            $tags[] = $line['tag'];
        }
        $tags = $this->Post_mdl->get_taglist_by_tagids(array_unique(explode(',', str_replace(',,', ',', implode('', $tags)))));        
        
        $html['categorys'] = $categorys;
        $html['category'] = $this->input->get('category') ? get_from_array($categorys, 'slug', $this->input->get('category'), 'id') : 0;
        $html['pagination'] = $this->pagination->create_links(); 
        $html['post'] = $post['list'];
        $html['tags'] = $tags;
        $this->load->view('admin/post', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Post::add()
     * 新增文章
     * @return void
     */
    public function add()
    {
        $categorys = $this->Category_mdl->get_list();
        $http_query = $this->input->get();
        
        if (isset($http_query['category'])) {
            $category = $this->Category_mdl->get('id', $http_query['category'], 'slug');
        } else {
            $category = $http_query['category'] ? $http_query['category'] : 0;
        }
        
        $html['categorys'] = $categorys;
        $html['category'] = $category;
        $html['default_template'] = $this->Category_mdl->get('temparticle', $category, 'id');
        $this->load->view('admin/postAdd', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Post::edit()
     * 编辑文章
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        $post = $this->Post_mdl->get('*', $id);
        if (!$post) {
            admintip('error:该文章不存在！');
        }
        $categorys = $this->Category_mdl->get_list();
        
        $html['categorys'] = $categorys;
        $html['post'] = $post;
        $this->load->view('admin/postEdit', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Post::save()
     * 保存链接
     * @return void
     */
    public function save()
    {
        $post = $this->input->post();
        if (isset($post['id'])) {
            $id = $post['id'];
            unset($post['id']);
            $return = $this->Post_mdl->update($post, $id);
            echo $return;
            if ($return !== false) {
                if ($return) {
                    $this->User_mdl->userlog_add('【文章】更新文章：' . $post['title']);
                    admintip('成功更新文章！');                     
                }
                admintip('没有做任何更改！'); 
            }
            admintip('error:更新失败，请检查缩略标题是否重复！');              
        } else {
            if ($this->Post_mdl->add($post)) {
                $this->User_mdl->userlog_add('【文章】新增文章：' . $post['title']);
                admintip('成功新增文章！');     
            }
            admintip('error:添加失败，请检查缩略标题是否重复！');        
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Post::del()
     * 删除文章
     * @param mixed $id
     * @return void
     */
    public function del($id)
    {
        $this->User_mdl->checkpurview();
        $post = $this->Post_mdl->del($id);
        if ($post) {
            $this->User_mdl->userlog_add('【文章】删除文章：' . $post['title']);
            admintip('成功删除文章！');              
        } 
        admintip('删除文章失败！');        
    }

    // ------------------------------------------------------------------------

    /**
     * Post::alldel()
     * 批量删除
     * @return void
     */
    public function alldel()
    {
        $this->User_mdl->checkpurview();
        $post = $this->input->post('id');
        if ($post) {
            $post = $this->Post_mdl->del($post);
            if ($post) {
                $this->User_mdl->userlog_add('【文章】批量删除'.$post.'项文章');
                admintip('成功批量删除'.$post.'项文章！');  
            }
            admintip('error:删除文章失败！');
        }
        admintip('error:请选择删除项目！');
    }
    
    /**
     * Post::view()
     * 预览
     * @param mixed $id
     * @return void
     */
    public function view($id) 
    {
        $post = $this->Post_mdl->get('category, slug', $id);
        $channeltype = $this->Category_mdl->get('channeltype', $post['category']);
        redirect($channeltype.'/'.$post['slug']);
    }
}

/* End of file post.php */
/* Location: ./application/controllers/admin/post.php */
