<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Online_edit extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
        $this->basepath = str_replace('\\', '/', str_replace('\\\\', '/',getcwd()));
    }

    // ------------------------------------------------------------------------

    /**
     * Online_edit::index()
     * 
     * @return void
     */
    public function index()
    {
        $prev_path = '';
        $path = $this->input->get('path') ? $this->input->get('path') : $this->basepath;
        $path = str_replace('\\', '/', str_replace('\\\\', '/',$path));
        if (strpos($path, $this->basepath) !== 0) admintip('error:非法目录!');
        if ($path) {
            !is_readable($path) && admintip('error:文件不可读，请检查权限是否为可读!');
            if (is_file($path)) {
                $prev_path = dirname($path);
                $f = fopen($path, 'r');
                $thefile = fread($f, filesize($path));
                fclose($f);   
            } elseif (is_dir($path)) {
                $prev_path = dirname($path);
                $thefile = glob($path.'/*');
            }
        } else {
            $thefile = glob($path.'/*');
        }
        
        $html['prev_path'] = $prev_path;
        $html['type'] = filetype($path);
        $html['thefile'] = $thefile;
        $this->load->view('admin/online_edit', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Online_edit::save()
     * 保存文件
     * @return void
     */
    public function save()
    {
        $path = $this->input->post('path');
        $path = str_replace('\\', '/', str_replace('\\\\', '/',$path));
        if (strpos($path, $this->basepath) !== 0) admintip('error:非法目录!');
        $content = $this->input->post('content');
        !is_file($path) && admintip('error:非文件无法保存！');
        !is_really_writable($path) && admintip('error:文件不可写，请检查权限是否为可写！');
        $f = fopen($path, 'w');
        if (fwrite($f, $content)) {
            $this->User_mdl->userlog_add('【系统】在线编辑文件：'.$path);
            fclose($f);
            admintip('成功保存文件！');
        }
    }

    // ------------------------------------------------------------------------
}

/* End of file online_edit.php */
/* Location: ./application/controllers/admin/online_edit.php */
