<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
        $this->load->vars(array('nav' => 'user'));
    }

    // ------------------------------------------------------------------------
    
    /**
     * User::index()
     * 用户首页
     * @return void
     */
    public function index()
    {
        $http_query = $this->input->get();        
        $users = $this->User_mdl->get_list($http_query);
    
        //分页
        $this->load->library('pagination');
        unset($http_query['page']);
        $page['base_url'] = '?'.($http_query ? http_build_query($http_query) : '');
        $page['total_rows'] = $users['total'];
        $page['per_page'] = 20;
        $this->pagination->initialize($page);
         
        $html['pagination'] = $this->pagination->create_links(); 
        $html['users'] = $users['list'];
        $html['group'] = $this->User_mdl->group;
        $this->load->view('admin/user', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * User::edit()
     * 编辑用户
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        $user = $this->User_mdl->get('*', $id);
        if (!$user) {
            admintip('error:该用户不存在！');
        }

        $html['user'] = $user;
        $html['group'] = $this->User_mdl->group;
        $this->load->view('admin/userEdit', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * User::save()
     * 保存链接
     * @return void
     */
    public function save()
    {
        $error = array(-1 => '用户名长度不符', -2 => '用户名格式不正确', -3 => '邮箱格式不正确', -4 => '密码长度不符', -5 => '用户名已经存在', -6 => '用户邮箱已经存在');
        
        $post = $this->input->post();
        if (isset($post['uid'])) {
            $id = $post['uid'];
            unset($post['uid']);
            $return = $this->User_mdl->update($post, $id);
            if ($return > -1) {
                if ($return) {
                    $this->User_mdl->userlog_add('【用户】更新用户：' . $post['username']);
                    admintip('成功更新用户！');                     
                }
                admintip('没有做任何更改！');    
            }
            admintip('error:更新失败，'.$error[$return]);              
        } else {
            $return = $this->User_mdl->add($post);
            if ($return > 1) {
                $this->User_mdl->userlog_add('【用户】新增用户：' . $post['username']);
                admintip('成功新增用户！');     
            }
            admintip('error:添加失败，'.$error[$return]);        
        }
    }

    // ------------------------------------------------------------------------

    /**
     * User::del()
     * 删除用户
     * @param mixed $id
     * @return void
     */
    public function del($id)
    {
        $user = $this->User_mdl->del($id);
        if ($user) {
            $this->User_mdl->userlog_add('【用户】删除用户：' . $user);
            admintip('成功删除用户！');               
        }
        admintip('error:删除用户失败！');
    }

    // ------------------------------------------------------------------------

    /**
     * User::alldel()
     * 批量删除
     * @return void
     */
    public function alldel()
    {
        $post = $this->input->post('id');
        if ($post) {
            $user = $this->User_mdl->del($post);
            if ($user) {
                $this->User_mdl->userlog_add('【用户】批量删除'.$user.'个用户');
                admintip('成功批量删除'.$user.'个用户！');                  
            }
            admintip('error:删除用户失败！');
        }
        admintip('error:请选择删除项目！');
    }

    // ------------------------------------------------------------------------
    
    /**
     * User::view()
     * 预览
     * @param mixed $id
     * @return void
     */
    public function view($id) 
    {
        $slug = $this->User_mdl->get('slug', $id);
        redirect('post/'.$slug);
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * User::userlog()
     * 用户日志列表
     * @return void
     */
    public function userlog() {
        $http_query = $this->input->get();        
        $userlog = $this->User_mdl->get_userlog_list($http_query);
        
        //分页
        $this->load->library('pagination');
        unset($http_query['page']);
        $page['base_url'] = '?'.($http_query ? http_build_query($http_query) : '');
        $page['total_rows'] = $userlog['total'];
        $page['per_page'] = 20;
        $this->pagination->initialize($page);
         
        $html['pagination'] = $this->pagination->create_links(); 
        $html['userlog'] = $userlog['list'];
        $html['types'] = $this->User_mdl->types;
        
        $this->load->view('admin/userlog', $html);        
    }

    // ------------------------------------------------------------------------

    /**
     * Post::del()
     * 删除用户日志
     * @param mixed $id
     * @return void
     */
    public function userlog_del($id)
    {
        $post = $this->User_mdl->userlog_del($id);
        $this->User_mdl->userlog_add('【用户日志】删除用户日志' );
        admintip('成功删除用户日志！');         
    }

    // ------------------------------------------------------------------------

    /**
     * User::userlog_alldel()
     * 批量删除用户日志
     * @return void
     */
    public function userlog_alldel()
    {
        $this->User_mdl->checkpurview();
        $post = $this->input->post('id');
        if ($post) {
            $post = $this->User_mdl->userlog_del($post);
            $this->User_mdl->userlog_add('【用户日志】批量删除用户日志');
            admintip('成功批量删除用户日志！');   
        }
        admintip('error:请选择删除项目！');
    }
    
}

/* End of file post.php */
/* Location: ./application/controllers/admin/post.php */
