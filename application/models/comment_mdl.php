<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * comment_mdl
 * 评论
 * @package   
 * @author Auror
 * @copyright owncms
 * @version 2013
 * @access public
 */
class Comment_mdl extends CI_Model
{
    const TABLE = 'comment';
    const TABLE_USER = 'user';
    const TABLE_POST = 'post';
    const TABLE_CATEFORY = 'category';
    /**
     * 构造函数
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    // ------------------------------------------------------------------------
    
    /**
     * Comment_mdl::get_list()
     * 根据条件获取评论
     * @param mixed $array
     * @return
     */
    public function get_list($array = array()) 
    {
        $array = $array && count($array) ? array_diff($array, array('')) : array();
        
        //uid
        if (isset($array['uid'])) {
            $sql[] = self::TABLE.'.uid = '.$array['uid'];
        }
        
        //username
        if (isset($array['username'])) {
            $sql[] = self::TABLE.'.username = \''.$array['username'].'\'';
        }
        
        //pid
        if (isset($array['pid'])) {
            $sql[] = self::TABLE.'.pid = '.$array['pid'];
        }
        
        //usermail
        if (isset($array['usermail'])) {
            $sql[] = self::TABLE.'.usermail = \''.$array['usermail'].'\'';
        }
        
        //ishidden
        if (isset($array['ishidden'])) {
            $sql[] = self::TABLE.'.ishidden = '.$array['ishidden'];
        }

        //ispass
        if (isset($array['ispass'])) {
            $sql[] = self::TABLE.'.ispass = '.$array['ispass'];
        }
        
        //select
        $select = isset($array['select']) ? $array['select'] : '*';
        
        //page
        $page = isset($array['page']) ? $array['page'] : 1;
        
        //limit
        $limit = isset($array['limit']) ? $array['limit'] : 20;
        
        //offset
        $offset = ($page - 1) * $limit;
        
        //orderby
        $orderby = isset($array['orderby']) ? $array['orderby'] : self::TABLE.'.id DESC';

        //onlylist 只输出list
        if (!isset($array['onlylist'])) {
            //计算总数
            $this->db->select('id');
            isset($sql) && $this->db->where(implode(' AND ', $sql));
            $return['total'] = $this->db->get(self::TABLE)->num_rows();            
        }
        
        //输出列表
        $this->db->select(add_table_prefix(self::TABLE, $select).','.add_table_prefix(self::TABLE_POST, 'id AS pid,title,slug,category').','.self::TABLE_CATEFORY.'.channeltype');
        $this->db->from(self::TABLE);
        $this->db->join(self::TABLE_POST, self::TABLE.'.pid = '.self::TABLE_POST.'.id', 'left');
        $this->db->join(self::TABLE_USER, self::TABLE.'.uid = '.self::TABLE_USER.'.uid', 'left');
        $this->db->join(self::TABLE_CATEFORY, self::TABLE_POST.'.category = '.self::TABLE_CATEFORY.'.id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by($orderby);
        isset($sql) && $this->db->where(implode(' AND ', $sql));
        
        $return['list'] = $this->db->get()->result_array();
               
        return $return;
    }

    // ------------------------------------------------------------------------
    
    /**
     * comment_mdl::add()
     * 新增评论
     * @param mixed $post
     * @return
     */
    public function add($post) 
    {
        $post = array_diff($post, array(''));
        $post['uid'] = $this->User_mdl->uid;
        $post['posttime'] = date('Y-m-d H:i:s');
        $post['ip'] = $this->input->ip_address();
        $post['content'] = htmlspecialchars($post['content']);
        $post['username'] = htmlspecialchars($post['username']);
        $post['userurl'] = isset($post['userurl']) ? htmlspecialchars($post['userurl']) : '';
        if (strlen($post['username']) < 1 || !preg_match('/^[\w]+@[a-zA-Z0-9]+.+[a-zA-Z]$/', $post['usermail']) || strlen($post['content']) < 1) {
            return false;
        }
        clear_this_cache($post['pid']);
        if ($this->db->insert(self::TABLE, $post)) {
            $insert_id = $this->db->insert_id();
            $this->db->set('comment_count', 'comment_count + 1', false)->where('id', $post['pid'])->update(self::TABLE_POST);
            return $insert_id;
        }
        return false;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Comment_mdl::get()
     * 获取评论
     * @param string $select
     * @param string $value
     * @param string $key
     * @param array $where
     * @return
     */
    public function get($select = '*', $value, $key = 'id', $where = array()) 
    {
        if (!$value) return false;
        $this->db->limit(1);
        $this->db->select($select);
        count($where) && $this->db->where($where);
        $data = $this->db->get_where(self::TABLE, array($key => $value))->row_array();

        if ($data && $select <> '*' && !strstr($select, ',')) {
            return $data[$select];
        }
        return $data;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Comment_mdl::update()
     * 更新评论
     * @param mixed $post
     * @param mixed $id
     * @return void
     */
    public function update($post, $id) 
    {
        if ($this->db->update(self::TABLE, $post, array('id' => $id))) {
            return $this->db->affected_rows();
        }
        return false;
    }
    
    // ------------------------------------------------------------------------
        
    /**
     * comment_mdl::del()
     * 删除评论
     * @param mixed $id
     * @return void
     */
    public function del($id) 
    {
        if (is_array($id)) {
            foreach ($id as $line) {
                $pid_array = $this->db->select('pid')->get_where(self::TABLE, array('id' => $line))->row_array();
                $pids[] = $pid_array['pid'];
            }
            $pids = array_count_values($pids);            
            foreach ($pids as $key => $value) {
                clear_this_cache($key);
                $this->db->set('comment_count', 'comment_count - '.$value, false)->where('id', $key)->update(self::TABLE_POST);
            }
            $this->db->where_in('id', $id);
            $this->db->delete(self::TABLE);
            return $this->db->affected_rows();
        }
        $this->db->set('comment_count', 'comment_count - 1', false)->where('id', $this->get('pid', $id))->update(self::TABLE_POST);
        clear_this_cache($this->get('pid', $id));
        $this->db->delete(self::TABLE, array('id' => $id));
        return true;
    }


}

/* End of file comment_mdl.php */
/* Location: ./application/models/comment_mdl.php */
