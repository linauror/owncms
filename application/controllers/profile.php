<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checklogin('login');
    }

    /**
     * 首页
     */
    public function index()
    {     
        $this->load->model('Friendlink_mdl');
        $this->load->model('Post_mdl');
        $this->load->model('Comment_mdl');
        
        $this->load->vars(array('current_nav' => 'index'));
        $post_list = $this->Post_mdl->get_list(array('select' => 'id', 'uid' => $this->User_mdl->uid)); 
        $html['user'] = $this->User_mdl->get('*', $this->User_mdl->uid);
        $html['post_list'] = $post_list;
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'id,category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => true, 'orderby' => 'click DESC', 'onlylist' => true));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view('profile_index', $html);
    }
    
    /**
     * Profile::update()
     * 更新信息
     * @return void
     */
    public function update()
    {
        $post = $this->input->post(null, true);
        if ($post) {
            $error = array(-1 => '账号长度不符', -2 => '账号格式不正确', -3 => '邮箱格式不正确', -4 => '密码长度不符', -5 => '用户名已经存在', -6 => '用户邮箱已经存在');
            $user['usermail'] = $post['usermail'];
            $user['userurl'] = $post['userurl'];
            $user['password'] = $post['password'];
            $user['username'] = $this->User_mdl->username;
            $update = $this->User_mdl->update($user, $this->User_mdl->uid);
            if ($update < 0) {
                show_error($error[$update]);
            }
            $this->User_mdl->loginout();
            show_message('成功更新资料，请重新登录！', 'login');            
        }
        redirect('profile');
    }
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */
