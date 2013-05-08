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
            $this->User_mdl->userlog_add('【系统配置】更新邮件配置');
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
        $testmailto = $this->input->post('testmailto');
        exit(sendmail($testmailto, 'test mail', 'it\'s just a test, from OWNCMS'));   
    }

    // ------------------------------------------------------------------------

}

/* End of file email.php */
/* Location: ./application/controllers/admin/email.php */
