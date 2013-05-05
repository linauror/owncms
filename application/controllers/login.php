<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller
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
        if ($this->User_mdl->uid) redirect('profile');
        $refer = $this->input->get('refer') ? $this->input->get('refer') : getrefer();
        $html['refer'] = $refer;
        
        $this->load->model('Friendlink_mdl');
        $this->load->model('Post_mdl');
        $this->load->model('Comment_mdl');
        
        $this->load->vars(array('current_nav' => 'index'));
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'id,category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => true, 'orderby' => 'click DESC', 'onlylist' => true));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view('login', $html);
        $this->output->cache(config_item('cache_time'));
    }

    // ------------------------------------------------------------------------

    /**
     * Login::logining()
     * 登录处理
     * @return void
     */
    public function logining()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $expired = $this->input->post('expired');
        $refer = $this->input->post('refer');
        $error = array(-1 => '用户被禁止', -2 => '密码错误', -3 => '用户不存在');
        if ($username && $password) {
            $login = $this->User_mdl->login($username, $password, $expired);
            if ($login['errorcode'] === 0) {
                $this->User_mdl->userlog_add('登录', 2, $login['user']['uid']);
                redirect($refer ? $refer : 'profile');
            } else {
                $this->User_mdl->userlog_add('登录失败：尝试同户名['.$username.']，尝试密码['.$password.']', 2);
                show_message($error[$login['errorcode']], 'login?refer='.$refer, '登录失败');
            }
        }
        else {
            show_message('请填写完整！', 'login?refer='.$refer, '错误提示');
        }
    }
    

    // ------------------------------------------------------------------------

    /**
     * Login::register()
     * 注册
     * @return void
     */
    public function register()
    {
        if ($this->User_mdl->uid) redirect('profile');
        $post = $this->input->post();
        if ($post) {
            $error = array(-1 => '账号长度不符', -2 => '账号格式不正确', -3 => '邮箱格式不正确', -4 => '密码长度不符', -5 => '用户名已经存在', -6 => '用户邮箱已经存在');
            $user['username'] = $post['username'];
            $user['password'] = $post['password'];
            $user['usermail'] = $post['usermail'];
            $user['userurl'] = $post['userurl'];
            $user['group'] = 3;
            $register = $this->User_mdl->add($user);
            if ($register < 0) {
                show_error($error[$register]);
            }
            show_message('恭喜你，注册成功，请登录', 'login');
        }
        
        $this->load->model('Friendlink_mdl');
        $this->load->model('Post_mdl');
        $this->load->model('Comment_mdl');
        
        $this->load->vars(array('current_nav' => 'index'));
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'id,category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => true, 'orderby' => 'click DESC', 'onlylist' => true));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view('register', $html);
        $this->output->cache(config_item('cache_time'));
    }    

    // ------------------------------------------------------------------------

    /**
     * Login::loginout()
     * 注销登录
     * @return void
     */
    public function loginout()
    {
        $this->User_mdl->userlog_add('注销登录', 2);
        $this->User_mdl->loginout();
        $refer = $this->input->get('refer');
        redirect($refer ? $refer : 'login');
    } 
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
