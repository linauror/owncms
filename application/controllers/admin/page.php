<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
        $this->load->model('Page_mdl');
        $this->load->vars(array('nav' => 'page'));
    }

    // ------------------------------------------------------------------------
    
    /**
     * Page::index()
     * 单页文档首页
     * @return void
     */
    public function index()
    {
        $page = $this->Page_mdl->get_list();
        $html['page'] = $page;
        $this->load->view('admin/page', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Page::add()
     * 新增单页文档
     * @return void
     */
    public function add()
    {
        $this->load->view('admin/pageAdd');
    }

    // ------------------------------------------------------------------------

    /**
     * Page::edit()
     * 编辑单页文档
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        $page = $this->Page_mdl->get('*', $id);
        if (!$page) {
            admintip('error:该单页文档不存在！');
        }
        $html['page'] = $page;
        $this->load->view('admin/pageEdit', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Page::save()
     * 保存链接
     * @return void
     */
    public function save()
    {
        $post = $this->input->post();
        if (isset($post['id'])) {
            $id = $post['id'];
            unset($post['id']);
            $return = $this->Page_mdl->update($post, $id);
            if ($return !== false) {
                if ($return) {
                    $this->User_mdl->userlog_add('【单页文档】更新单页文档：' . $post['title']);
                    admintip('成功更新单页文档！');                       
                }
                admintip('没有做任何更改！');
            }
            admintip('error:更新失败，请检查缩略标题是否重复！');              
        } else {
            if ($this->Page_mdl->add($post)) {
                $this->User_mdl->userlog_add('【单页文档】新增单页文档：' . $post['title']);
                admintip('成功新增单页文档！');     
            }
            admintip('error:添加失败，请检查缩略标题是否重复！');        
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Page::del()
     * 删除单页文档
     * @param mixed $id
     * @return void
     */
    public function del($id)
    {
        $page = $this->Page_mdl->del($id);
        if ($page) {
            $this->User_mdl->userlog_add('【单页文档】删除单页文档：' . $page['title']);
            admintip('成功删除单页文档！');             
        }
        admintip('error:删除单页文档失败！');        
    }

    // ------------------------------------------------------------------------

    /**
     * Page::alldel()
     * 批量删除
     * @return void
     */
    public function alldel()
    {
        $post = $this->input->post('id');
        if ($post) {
            $page = $this->Page_mdl->del($post);
            if ($page) {
                $this->User_mdl->userlog_add('【单页文档】批量删除'.$page.'项单页文档');
                admintip('成功批量删除'.$page.'项单页文档！');                  
            }
            admintip('error:删除单页文档失败！');
        }
        admintip('error:请选择删除项目！');
    }
    
    /**
     * Page::view()
     * 预览
     * @param mixed $id
     * @return void
     */
    public function view($id) 
    {
        $slug = $this->Page_mdl->get('slug', $id);
        redirect('page/'.$slug);
    }
}

/* End of file page.php */
/* Location: ./application/controllers/admin/page.php */
