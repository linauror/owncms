<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    // ------------------------------------------------------------------------
    
    /**
     * Login::index()
     * 
     * @return void
     */
    public function index()
    {
        if ($this->User_mdl->uid) redirect('admin/index');
        $refer = $this->input->get('refer') ? $this->input->get('refer') : getrefer();
        $html['refer'] = $refer;
        $this->load->view('admin/login', $html);
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
                redirect($refer ? $refer : 'admin/index');
            } else {
                $this->User_mdl->userlog_add('登录失败：尝试同户名['.$username.']，尝试密码['.$password.']', 2);
                show_message($error[$login['errorcode']], 'admin/login?refer='.$refer, '登录失败');
            }
        }
        else {
            show_message('请填写完整！', 'admin/login?refer='.$refer, '错误提示');
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
        redirect($refer ? $refer : 'admin/login');
    }

}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */
