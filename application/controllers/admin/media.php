<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview(2);
        $this->load->model('Media_mdl');
        $this->load->vars(array('nav' => 'media'));
        $this->load->vars(array('pic_types' => array('jpg', 'gif', 'png', 'jpeg')));
    }

    // ------------------------------------------------------------------------
    
    /**
     * Media::index()
     * 媒体首页
     * @return void
     */
    public function index()
    {        
        $http_query = $this->input->get();        
        $media = $this->Media_mdl->get_list($http_query);
    
        //分页
        $this->load->library('pagination');
        unset($http_query['page']);
        $page['base_url'] = '?'.($http_query ? http_build_query($http_query) : '');
        $page['total_rows'] = $media['total'];
        $page['per_page'] = 20;
        $this->pagination->initialize($page);
        
        $html['media'] = $media;
        $html['pagination'] = $this->pagination->create_links(); 
        $this->load->view('admin/media', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Media::add()
     * 新增媒体
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
     * Media::edit()
     * 编辑媒体
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        $media = $this->Media_mdl->get('*', $id);
        if (!$media) {
            admintip('error:该媒体不存在！');
        }
        
        $html['media'] = $media;
        $this->load->view('admin/mediaEdit', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Media::save()
     * 保存链接
     * @return void
     */
    public function save()
    {
        $media = $this->input->post();
        if (isset($media['id'])) {
            $id = $media['id'];
            unset($media['id']);
            if ($this->Media_mdl->update($media, $id)) {
                $this->User_mdl->userlog_add('【媒体】更新媒体：' . $media['title']);
                admintip('成功更新媒体！');     
            } else {
                admintip('没有做任何更改!'); 
            }             
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Media::del()
     * 删除媒体
     * @param mixed $id
     * @return void
     */
    public function del($id)
    {
        $this->User_mdl->checkpurview();
        $media = $this->Media_mdl->del($id);
        if ($media) {
            $this->User_mdl->userlog_add('【媒体】删除媒体：' . $media['title']);
            admintip('成功删除媒体！');              
        } 
        admintip('error:删除媒体失败！');      
    }

    // ------------------------------------------------------------------------

    /**
     * Media::alldel()
     * 批量删除
     * @return void
     */
    public function alldel()
    {
        $this->User_mdl->checkpurview();
        $media = $this->input->post('id');
        if ($media) {
            $media = $this->Media_mdl->del($media);
            $this->User_mdl->userlog_add('【媒体】批量删除'.$media.'项媒体');
            admintip('成功批量删除'.$media.'项媒体！');   
        }
        admintip('error:请选择删除项目！');
    }
}

/* End of file media.php */
/* Location: ./application/controllers/admin/media.php */
