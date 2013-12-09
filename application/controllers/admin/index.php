<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview(2);
        $this->load->model('Category_mdl');
        $categorys = $this->Category_mdl->get_list();
    }

    // ------------------------------------------------------------------------

    /**
     * 后台首页
     * @link : index.php/admin/index.html
     * @param :
     * @return : 
     */
    public function index()
    {
        $this->load->view('admin/index');
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * Index::update()
     * 系统升级 20131209文章对应标签转移到关系表
     * @return void
     */
    public function update() {
        $this->db->select('id,tag');
        $posts = $this->db->get('post')->result_array();
        $insert = array();
        foreach ($posts as $key => $line) {
            $tags = array();
            if ($line['tag']) {
                $tags = explode(',', $line['tag']);
                $tags = array_diff($tags, array(''));
                foreach ($tags as $keyA => $lineA) {
                    $insert[$key . $keyA] = array('key' => $line['id'], 'value' => $lineA, 'type' => 'pt');
                }
            }
        }
        $this->db->insert_batch('relation', $insert);
        echo '升级完成，可删除此段！';
    }
}

/* End of file index.php */
/* Location: ./application/controllers/admin/index.php */
