<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
        $this->load->model('Category_mdl');
        $this->load->vars(array('nav' => 'category'));
    }

    public function index() 
    {
        $category = $this->Category_mdl->get_list(array('postcount' => true));
        $html['category'] = $category;
        $this->load->view('admin/category', $html);
    }
    // ------------------------------------------------------------------------

    /**
     * Category::edit()
     * 编辑分类目录
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        $category = $this->Category_mdl->get('*', $id);
        if (!$category) {
            admintip('error:该分类目录不存在！');
        }
        $categorys = $this->Category_mdl->get_list();
        
        $html['categorys'] = $categorys;
        $html['category'] = $category;
        $this->load->view('admin/categoryEdit', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Category::save()
     * 保存链接
     * @return void
     */
    public function save()
    {
        $post = $this->input->post();
        if (isset($post['id'])) {
            $id = $post['id'];
            unset($post['id']);
            $return = $this->Category_mdl->update($post, $id);
            if ($return !== false) {
                if ($return) {
                    $this->User_mdl->userlog_add('【分类目录】更新分类目录：' . $post['typename'].'['.$post['slug'].']');
                    admintip('成功更新分类目录！');                     
                }
                admintip('没做任何更改！');    
            }
            admintip('error:更新失败，请检查缩略标题是否重复！');              
        } else {
            if ($this->Category_mdl->add($post)) {
                $this->User_mdl->userlog_add('【分类目录】新增分类目录：' . $post['typename'].'['.$post['slug'].']');
                admintip('成功新增分类目录！');     
            }
            admintip('error:添加失败，请检查缩略标题是否重复！');        
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Category::del()
     * 删除分类目录
     * @param mixed $id
     * @return void
     */
    public function del($id)
    {
        $category = $this->Category_mdl->del($id);
        if ($category) {
            $this->User_mdl->userlog_add('【分类目录】删除分类目录：' . $category['typename'].'['.$category['slug'].']');
            admintip('成功删除分类目录！');             
        } 
        admintip('error:删除分类目录失败！');           
    }

    // ------------------------------------------------------------------------

    /**
     * Category::alldel()
     * 批量删除
     * @return void
     */
    public function alldel()
    {
        $post = $this->input->post('id');
        if ($post) {
            $category = $this->Category_mdl->del($post);
            if ($category) {
                $this->User_mdl->userlog_add('【分类目录】批量删除'.$category.'项分类目录');
                admintip('成功批量删除'.$category.'项分类目录！');                  
            }
            admintip('error:删除分类目录失败！');  
        }
        admintip('error:请选择删除项目！');
    }
    
    /**
     * Category::view()
     * 预览
     * @param mixed $id
     * @return void
     */
    public function view($id) 
    {
        $slug = $this->Category_mdl->get('slug', $id);
        redirect('category/'.$slug);
    }
}

/* End of file category.php */
/* Location: ./application/controllers/admin/category.php */
