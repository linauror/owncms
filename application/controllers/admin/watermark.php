<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Watermark extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
    }

    // ------------------------------------------------------------------------

    /**
     * Watermark::index()
     * 
     * @return void
     */
    public function index()
    {
        $this->load->config('image_lib', true);
        $html['config'] = $this->config->item('image_lib');
        $this->load->view('admin/watermark', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Watermark::save()
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
        $str .= "\n\n/* End of file image_lib.php */\n/* Location: ./application/config/image_lib.php */";
        if (file_put_contents('application/config/image_lib.php', $str))
        {
            $this->User_mdl->userlog_add('更新图片水印配置');
            admintip('成功更新图片水印配置！');
        }
        else
        {
            admintip('error:更新图片水印配置失败，请检查文件权限！');
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Watermark::test()
     * 示例
     * @return void
     */
    public function test()
    {
        include ('application/config/image_lib.php');
        $config['dynamic_output'] = true;

        $this->load->library('image_lib', $config);
        if (!$this->image_lib->watermark())
            echo $this->image_lib->display_errors();
    }

    // ------------------------------------------------------------------------

}

/* End of file watermark.php */
/* Location: ./application/controllers/admin/watermark.php */
