<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checklogin();
    }

    // ------------------------------------------------------------------------

    public function index()
    {
        $this->upload();
    }

    // ------------------------------------------------------------------------

    /**
     * Upload::upload()
     * 传统上传方式
     * @return void
     */
    public function upload()
    {
        include(getcwd() . '/application/config/upload.php');
        $FILES = array_keys($_FILES);
        $config['fileinput'] = $FILES[0];
        $new_upload_path = $config['upload_path'].date('Ym').'/';
        $config['upload_path'] = getcwd().'/'.$new_upload_path;
        if (!is_dir($config['upload_path']))
        {
            @mkdir($config['upload_path'], 0777);
            @chmod($config['upload_path'], 0777);
            @fclose(fopen($config['upload_path'] . '/index.html', 'w'));
        }        
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($config['fileinput'])) {
            $err = $this->upload->display_errors();
            exit("{'err':'" . strip_tags($err . "'}"));
        } else {
            $data = $this->upload->data();
            if (getimagesize($data['full_path'])) $this->watermark($data['full_path']); //是图片才会处理水印
			$url = '/' . $new_upload_path.$data['file_name'];
            $localname = $data['client_name'];
            //写入数据库
            $this->load->model('Media_mdl');
            $id = $this->Media_mdl->add(array('uid' => $this->User_mdl->uid, 'title' => $data['client_name'], 'filepath' => $url, 'suffix' => str_replace('.', '', $data['file_ext'])));
            
            exit("{'err':'','msg':{'url':'" . $url . "','localname':'" . ($localname) ."','id':'". ($id)."'}}");
        }
    }

    // ------------------------------------------------------------------------
    
    /**
     * Upload::watermark()
     * 添加水印
     * @param mixed $imagepath
     * @return void
     */
    public function watermark($imagepath)
    {
        include (getcwd() . '/application/config/image_lib.php');
        if ($config['wm_ing'] == 1)
        {
            $config['source_image'] = $imagepath;
            $this->load->library('image_lib', $config);
            $this->image_lib->watermark();
        }
    }
    
    
}

/* End of file upload.php */
/* Location: ./application/controllers/admin/upload.php */
