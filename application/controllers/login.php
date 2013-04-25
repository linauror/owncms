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
        $categorys= $this->Category_mdl->get_list();
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['categorys'] = $categorys;
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => true, 'orderby' => 'click DESC', 'onlylist' => true));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view('login', $html);
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
