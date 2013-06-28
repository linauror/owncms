<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Post extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Post_mdl');
    }

    /**
     * 首页
     */
    public function index($id)
    {
        $post = $this->Post_mdl->get('*', $id, 'id', array('ishidden' => 0));
        if (!$post) show_error('此页面不存在');
        
        $this->load->model('Friendlink_mdl');
        $this->load->model('Category_mdl');
        $this->load->model('Comment_mdl');

        $categorys= $this->Category_mdl->get_list();
        $this->load->vars(array('current_nav' => 'category/'.get_from_array($categorys, 'id', $post['category'], 'slug')));
        $thetag = $this->Post_mdl->get_taglist_by_tagids($post['tag']);
        
        $html['siteconfig'] = $this->Siteconfig_mdl->get_list(array('varname' => 'sitename,keyword,description', 'select' => 'varname,value'), true);
        $html['categorys'] = $categorys;
        $html['post'] = $post;
        $html['thetag'] = $thetag;
        $html['comments_list'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 1000, 'pid' => $post['id'], 'orderby' => 'id ASC', 'onlylist' => true));
        $html['near_post'] = $this->Post_mdl->get_near_post($post['id'], 'id,slug,category,title');
        $html['post_hot'] = $this->Post_mdl->get_list(array('select' => 'id,category,title,slug,click,posttime', 'ishidden' => 0, 'limit' => 10, 'posttime' => true, 'orderby' => 'click DESC', 'onlylist' => true));
        $html['comments_new'] = $this->Comment_mdl->get_list(array('ishidden' => 0, 'ispass' => 1, 'limit' => 10, 'onlylist' => true));
        $html['friendlink'] = $this->Friendlink_mdl->get_list(array('ishidden' => 0));
        $this->load->view($post['template'], $html);
    }
    
    /**
     * Post::ACT_comment_submit()
     * 发表评论
     * @return void
     */
    public function ACT_comment_submit()
    {
        $post = $this->input->post(null, true);
        $now = mktime();
        if ($post['notRobot'] < $now - 600 || $post['notRobot'] > $now + 600) {
            show_error('你这货不会是机器人吧！');
        }
        $thepost = $this->Post_mdl->get('id', $post['pid'], 'id', array('ishidden' => '0', 'comment_status' => 1));
        if (!$thepost) {show_error('不允许评论的文章！');}
        $current_url = $post['current_url'];
        if (count($post) < 7) show_error('请填写完整！');
        $comment = array(
            'pid' => $post['pid'],
            'reid' => $post['reid'],
            'username' => $post['username'],
            'usermail' => $post['usermail'],
            'userurl' => $post['userurl'],
            'content' => $post['content'],
        );
        $this->load->model('Comment_mdl');
        $comment = $this->Comment_mdl->add($comment);
        if ($comment) {
            redirect($current_url.'#comments_id_'.$comment);
        } else {
            show_error('发表评论出错！');
        }
    }
    
    /**
     * Post::ACT_update_click()
     * 更新浏览量
     * @return void
     */
    public function ACT_update_click()
    {
        if ($this->input->post('id', true)) {
            $this->load->model('Post_mdl');
            $this->Post_mdl->update_field('click', $this->input->post('id')); //更新浏览量            
        }
    }
    
    /**
     * Post::ACT_show_edit_link()
     * 检测是否有编辑权限
     * @return void
     */
    public function ACT_show_edit_link()
    {
        $uid = $this->User_mdl->uid;
        if (!$uid) exit('{"status" : "no"}');
        $get = $this->input->get(null, true);
        $group = $this->User_mdl->get('group', $uid);
        $return['status'] = 'yes';
        if ($group < 3) {
            $return['url'] = site_url('admin/post/edit/'.$get['id']);
            exit(json_encode($return));
        } elseif ($get['uid'] == $uid) {
            $return['url'] = site_url('profile/post_edit/'.$get['id']);
            exit(json_encode($return));           
        } else{
            exit('{"status" : "no"}');
        }
    }      
}

/* End of file post.php */
/* Location: ./application/controllers/post.php */
