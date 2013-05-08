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
                $this->User_mdl->userlog_add('【登录】登录', 2, $login['user']['uid']);
                redirect($refer ? $refer : 'profile');
            } else {
                $this->User_mdl->userlog_add('【登录】登录失败：尝试同户名['.$username.']，尝试密码['.$password.']', 2);
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
     * Login::verify()
     * 激活邮箱
     * @return void
     */
    public function verify()
    {
        $data = $this->input->get();
        $now = mktime();
        if ($now - $data['time'] > 600) {
            show_error('此链接已经过期！');
        } elseif ($data['auth'] != md5($data['time'].$data['uid'].$data['username'].$data['usermail'].config_item('encryption_key'))) {
            show_error('无效的链接！');
        }
        $this->User_mdl->update(array('isverify' => 1, 'username' => $data['username'], 'usermail' => $data['usermail']), $data['uid']);
        $this->User_mdl->userlog_add('【用户】激活邮箱', 2, $data['uid']);
        show_message($data['username'].'，恭喜你，成功激活邮箱！', 'index');
    } 

    // ------------------------------------------------------------------------

    /**
     * Login::verify()
     * 重新发送激活邮件
     * @return void
     */
    public function resend_verifymail()
    {
        if ($this->User_mdl->uid) {
            $user = $this->User_mdl->get('username,usermail,uid,isverify', $this->User_mdl->uid);
            if ($user['isverify']) exit('邮箱已经激活！');
            $now = mktime();
            $url = site_url('login/verify?time='.$now.'&uid='.$user['uid'].'&username='.$user['username'].'&usermail='.$user['usermail'].'&auth='.md5($now.$user['uid'].$user['username'].$user['usermail'].config_item('encryption_key')));
            $message = $this->load->view('email_tpl/register', array('username' => $user['username'], 'url' => $url), true);
            sendmail($user['usermail'], '欢迎注册本网站，请激活邮箱', $message);
            exit('success');            
        }
        exit('尚未登录！');
    } 
    // ------------------------------------------------------------------------

    /**
     * Login::getpassword_submit()
     * 忘记密码提交
     * @return void
     */
    public function getpassword_submit()
    {
        $username = $this->input->post('username');
        if (strpos($username, '@')) {
            $user = $this->User_mdl->get('uid,usermail,username', $username, 'usermail');
        } else {
            $user = $this->User_mdl->get('uid,usermail,username', $username, 'username');
        }
        if ($user) {
            $now = mktime();
            $url = site_url('login/getpassword?time='.$now.'&uid='.$user['uid'].'&username='.$user['username'].'&usermail='.$user['usermail'].'&auth='.md5($now.$user['uid'].$user['username'].$user['usermail'].config_item('encryption_key')));
            $message = $this->load->view('email_tpl/getpassword', array('username' => $user['username'], 'url' => $url), true);
            sendmail($user['usermail'], '您申请了找回密码', $message);
            
            $hiddenmailA = strpos($user['usermail'], '@');
            $hiddenmail = substr_replace($user['usermail'], '***', $hiddenmailA - 3, 3);
            
            $this->User_mdl->userlog_add('【用户】申请找回密码', 2, $user['uid']);
            show_message('已经发送验证邮件至您的绑定邮箱['.$hiddenmail.']，请查收！');            
        } else {
            show_error('不存在此用户/邮箱，请重新输入！');
        }
    } 

    // ------------------------------------------------------------------------

    /**
     * Login::getpassword()
     * 重置密码
     * @return void
     */
    public function getpassword()
    {
        $post = $this->input->post();
        $data = $post ? $post : $this->input->get();
        $now = mktime();
        if ($now - $data['time'] > 600) {
            show_error('此链接已经过期！');
        } elseif ($data['auth'] != md5($data['time'].$data['uid'].$data['username'].$data['usermail'].config_item('encryption_key'))) {
            show_error('无效的链接！');
        }
        
        if ($post) {
            $this->User_mdl->update(array('username' => $data['username'], 'usermail' => $data['usermail'], 'password' => $data['password']), $data['uid']); 
            $this->User_mdl->userlog_add('【用户】重置密码', 2, $data['uid']);
            show_message('成功修改密码，请登录', 'login');   
        }

        $this->load->model('Friendlink_mdl');
        $this->load->model('Post_mdl');
        $this->load->model('Comment_mdl');
        
        $this->load->vars(array('current_nav' => 'index'));
        $html['data'] = $data;
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'id,category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => true, 'orderby' => 'click DESC', 'onlylist' => true));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view('getpassword', $html);      
    } 
    
    // ------------------------------------------------------------------------

    /**
     * Login::loginout()
     * 注销登录
     * @return void
     */
    public function loginout()
    {
        $this->User_mdl->userlog_add('【用户】注销登录', 2);
        $this->User_mdl->loginout();
        $refer = $this->input->get('refer');
        redirect($refer ? $refer : 'login');
    } 
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
