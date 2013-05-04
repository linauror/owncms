<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
        $this->load->model('Menu_mdl');
        $this->load->model('Category_mdl');
        $this->load->model('Page_mdl');
        $this->load->vars(array('nav' => 'menu', 'types' => $this->Menu_mdl->types, 'targets' => $this->Menu_mdl->targets));
    }

    public function index() 
    {
        $categorys = $this->Category_mdl->get_list();
        $pages = $this->Page_mdl->get_list();
        $menus = $this->Menu_mdl->get_list();
        
        $html['categorys'] = $categorys;
        $html['pages'] = $pages;
        $html['menus'] = $menus;
        $this->load->view('admin/menu', $html);
    }
    
    // ------------------------------------------------------------------------

    /**
     * Menu::edit()
     * 编辑菜单
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        $menu = $this->Menu_mdl->get('*', $id);
        if (!$menu) {
            admintip('error:该菜单不存在！');
        }
        $menus = $this->Menu_mdl->get_list();
        
        $html['menus'] = $menus;
        $html['menu'] = $menu;
        $this->load->view('admin/menuEdit', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Menu::save()
     * 保存链接
     * @return void
     */
    public function save()
    {
        $post = $this->input->post();
        if (isset($post['id'])) {
            $id = $post['id'];
            unset($post['id']);
            $return = $this->Menu_mdl->update($post, $id);
            if ($return !== false) {
                if ($return) {
                    $this->User_mdl->userlog_add('【菜单】更新菜单：' . $post['nav'].'['.$post['url'].']');
                    admintip('成功更新菜单！');                     
                }
                admintip('没有做任何更改！'); 
            }
            admintip('error:更新失败，请检查缩略标题是否重复！');              
        } else {
            $type = $this->input->post('type');
            switch ($type) {
                case 'page' :
                    $post['nav'] = $this->Page_mdl->get('title', $post['url'], 'slug');
                    $post['url'] = 'page/'.$post['url'];
                    break;
                case 'category' :
                    $post['nav'] = $this->Category_mdl->get('typename', $post['url'], 'slug');
                    $post['url'] = 'category/'.$post['url'];
                    break;                    
            }
            if ($this->Menu_mdl->add($post)) {
                $this->User_mdl->userlog_add('【菜单】新增菜单：' . $post['nav']);
                admintip('成功新增菜单！');     
            }
            admintip('error:添加失败，请检查是否重复添加！');        
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Menu::del()
     * 删除菜单
     * @param mixed $id
     * @return void
     */
    public function del($id)
    {
        $menu = $this->Menu_mdl->del($id);
        if ($menu) {
            $this->User_mdl->userlog_add('【菜单】删除菜单：' . $menu['nav']);
            admintip('成功删除菜单！');              
        }
        admintip('error:删除菜单失败！');       
    }
    
    /**
     * Menu::view()
     * 预览
     * @param mixed $id
     * @return void
     */
    public function view($id) 
    {
        $url = $this->Menu_mdl->get('url', $id);
        redirect($url);
        
    }
}

/* End of file category.php */
/* Location: ./application/controllers/admin/category.php */
