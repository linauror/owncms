<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
        $this->load->model('Comment_mdl');
        $this->load->vars(array('nav' => 'comment'));
    }

    // ------------------------------------------------------------------------
    
    /**
     * Comment::index()
     * 评论首页
     * @return void
     */
    public function index()
    {
        $http_query = $this->input->get();        
        $comment = $this->Comment_mdl->get_list($http_query);
        //分页
        $this->load->library('pagination');
        unset($http_query['page']);
        $page['base_url'] = '?'.($http_query ? http_build_query($http_query) : '');
        $page['total_rows'] = $comment['total'];
        $page['per_page'] = 20;
        $this->pagination->initialize($page);
        //print_r($comment);
        
        $html['comment'] = $comment['list'];
        $html['pagination'] = $this->pagination->create_links();
        $this->load->view('admin/comment', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Comment::edit()
     * 编辑评论
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        $comment = $this->Comment_mdl->get('id', $id);
        if (!$comment) {
            admintip('error:该评论不存在！');
        }
        $post = $this->input->get();
        if (isset($post['ishidden'])) {
            $post['ishidden'] = $post['ishidden'] ? 0 : 1;
        }
        if (isset($post['ispass'])) {
            $post['ispass'] = $post['ispass'] ? 0 : 1;
        }
        $this->Comment_mdl->update($post, $id);
        $this->User_mdl->userlog_add('【评论】更新评论状态');
        admintip('成功更新评论状态！');       
    }

    // ------------------------------------------------------------------------

    /**
     * Comment::del()
     * 删除评论
     * @param mixed $id
     * @return void
     */
    public function del($id)
    {
        if ($this->Comment_mdl->del($id)) {
            $this->User_mdl->userlog_add('【评论】删除评论');
            admintip('成功删除评论！');                 
        }
        admintip('error:删除评论失败！'); 
    }

    // ------------------------------------------------------------------------

    /**
     * Comment::alldel()
     * 批量删除
     * @return void
     */
    public function alldel()
    {
        $post = $this->input->post('id');
        if ($post) {
            $comment = $this->Comment_mdl->del($post);
            if ($comment) {
                $this->User_mdl->userlog_add('【评论】批量删除评论');
                admintip('成功批量删除评论！');                 
            }
            admintip('error:删除评论失败！');   
        }
        admintip('error:请选择删除项目！');
    }
}

/* End of file comment.php */
/* Location: ./application/controllers/admin/comment.php */
