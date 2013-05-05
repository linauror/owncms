<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
    }

    // ------------------------------------------------------------------------

    /**
     * Email::index()
     * 
     * @return void
     */
    public function index()
    {
        $this->load->config('email', true);
        $html['config'] = $this->config->item('email');
        $this->load->view('admin/email', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Email::save()
     * 保存设置
     * @return void
     */
    public function save()
    {
        $post = $this->input->post();
        $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n\n";
        foreach ($post as $key => $value)
        {
            $str .= '$' . "config['" . $key . "'] = '" . $value . "';\n";
        }
        $str .= "\n\n/* End of file email.php */\n/* Location: ./application/config/email.php */";
        if (file_put_contents('application/config/email.php', $str))
        {
            $this->User_mdl->userlog_add('更新邮件配置');
            admintip('成功更新邮件配置！');
        }
        else
        {
            admintip('error:更新邮件配置失败，请检查文件权限！');
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Email::test()
     * 示例
     * @return void
     */
    public function test()
    {
        include ('application/config/email.php');
        $this->load->library('email', $config);
        $testmailto = $this->input->post('testmailto');
        $this->email->from($config['smtp_user'], $config['smtp_user']);
        $this->email->to($testmailto);
        $this->email->subject('test mail');
        $this->email->message('it\'s just a test, from OWNCMS');
        if ($this->email->send()) {
            exit('success');
        }
        exit($this->email->print_debugger());   
    }

    // ------------------------------------------------------------------------

}

/* End of file email.php */
/* Location: ./application/controllers/admin/email.php */
