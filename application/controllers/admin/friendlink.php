<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Friendlink extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
        $this->load->model('Friendlink_mdl');
        $this->load->vars(array('nav' => 'friendlink'));
    }

    // ------------------------------------------------------------------------

    public function index()
    {
        $friendlink = $this->Friendlink_mdl->get_list();
        $html['friendlink'] = $friendlink;
        $this->load->view('admin/friendlink', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Friendlink::add()
     * 新增友情链接
     * @return void
     */
    public function add()
    {
        $this->load->view('admin/friendlinkAdd');
    }

    // ------------------------------------------------------------------------

    /**
     * Friendlink::edit()
     * 编辑友情链接
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        $friendlink = $this->Friendlink_mdl->get('*', $id);
        if (!$friendlink) {
            admintip('error:该条友情链接不存在！');
        }
        $html['friendlink'] = $friendlink;
        $this->load->view('admin/friendlinkEdit', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Friendlink::save()
     * 保存链接
     * @return void
     */
    public function save()
    {
        $post = $this->input->post();
        if (isset($post['id'])) {
            $id = $post['id'];
            unset($post['id']);
            $return = $this->Friendlink_mdl->update($post, $id);
            if ($return !== false) {
                if ($return) {
                    $this->User_mdl->userlog_add('【友情链接】更新友情链接：' . $post['title'] . '[' . $post['url'] . ']');
                    admintip('成功更新友情链接！');                     
                }
                admintip('没有做任何更改！');  
            }
            admintip('error:更新失败！');             
        } else {
            if ($this->Friendlink_mdl->add($post)) {
                $this->User_mdl->userlog_add('【友情链接】新增友情链接：' . $post['title'] . '[' . $post['url'] . ']');
                admintip('成功新增友情链接！');                  
            }
            admintip('error:新增友情链接失败！');
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Friendlink::del()
     * 删除友情链接
     * @param mixed $id
     * @return void
     */
    public function del($id)
    {
        $friendlink = $this->Friendlink_mdl->del($id);
        if ($friendlink) {
            $this->User_mdl->userlog_add('【友情链接】删除友情链接：' . $post['title'] . '[' . $post['url'] . ']');
            admintip('成功删除友情链接！');             
        }
        admintip('error:删除友情链接失败！');        
    }

    // ------------------------------------------------------------------------

    /**
     * Friendlink::alldel()
     * 批量删除
     * @return void
     */
    public function alldel()
    {
        $post = $this->input->post('id');
        if ($post) {
            $friendlink = $this->Friendlink_mdl->del($post);
            if ($friendlink) {
                $this->User_mdl->userlog_add('【友情链接】批量删除'.$friendlink.'项友情链接');
                admintip('成功批量删除'.$friendlink.'项友情链接！');                  
            }
            admintip('error:删除友情链接失败！');
        }
        admintip('error:请选择删除项目！');
    }
}

/* End of file friendlink.php */
/* Location: ./application/controllers/admin/friendlink.php */
