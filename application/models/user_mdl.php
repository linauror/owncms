<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * User_mdl
 * 用户模块
 * @package   
 * @author Auror
 * @copyright owncms
 * @version 2013
 * @access public
 */
class User_mdl extends CI_Model
{

    const TABLE = 'user';
    const TABLE_LOG = 'userlog';
        
    public $uid = 0;
    public $username = '';
    public $usermail = '';
    private $userlogin_cookiename;
    private $userlogin_expired;
    private $encryption_key;
    
    public $group = array('1' => '管理员', '2' => '编辑', '3' => '普通会员');

    // ------------------------------------------------------------------------

    /**
     * 构造函数
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->userlogin_cookiename = config_item('userlogin_cookiename');
        $this->userlogin_expired = config_item('userlogin_expired');
        $this->encryption_key = config_item('encryption_key');
        $this->auth();
    }

    // ------------------------------------------------------------------------
    
    /**
     * User_mdl::get_list()
     * 用户列表
     * @param mixed $where
     * @param string $perpage
     * @param string $orderby
     * @return
     */
    public function get_list($array = array()) 
    {
        $array = $array && count($array) ? array_diff($array, array('')) : array();
        
        //group
        if (isset($array['group'])) {
            $sql[] = self::TABLE.'.group = '.$array['group'];
        }
        
        //uid
        if (isset($array['uid'])) {
            $sql[] = self::TABLE.'.uid = '.$array['uid'];
        }

        //username
        if (isset($array['username'])) {
            $sql[] = self::TABLE.'.username LIKE \'%'.$array['username'].'%\'';
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
        $orderby = isset($array['orderby']) ? $array['orderby'] : 'uid DESC';
        
        //onlylist 只输出list
        if (!isset($array['onlylist'])) {
            //计算总数
            $this->db->select('uid');
            isset($sql) && $this->db->where(implode(' AND ', $sql));
            $return['total'] = $this->db->get(self::TABLE)->num_rows();            
        }
        
        //输出列表
        $this->db->select($select);
        $this->db->limit($limit, $offset);
        $this->db->order_by($orderby);
        isset($sql) && $this->db->where(implode(' AND ', $sql));
        
        $return['list'] = $this->db->get(self::TABLE)->result_array();
        
        return $return;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Post_mdl::add()
     * 新增用户
     * @param mixed $post
     * @return
     */
    public function add($post) 
    {
        $post = array_diff($post, array(''));
        if (strlen($post['username']) < 4 || strlen($post['username']) > 20) return -1; //用户名长度不符
        if (!preg_match('/^[\w]+$/', $post['username'])) return -2; //用户名格式不正确
        if (!preg_match('/^[\w]+@[a-zA-Z0-9]+.+[a-zA-Z]$/', $post['usermail'])) return -3; //邮箱格式不正确
        if (strlen($post['password']) < 6 || strlen($post['username']) > 20) return -4; //密码长度不符
        
        if ($this->checkuser('username', $post['username'])) return -5; //用户名已经存在
        if ($this->checkuser('usermail', $post['usermail'])) return -6; //用户邮箱已经存在
        
        $this->load->library('encrypt');
        $post['password'] = md5($post['password']. $this->encryption_key);
        $post['regip'] = $this->input->ip_address();
        $post['regtime'] = date('Y-m-d H:i:s');
              
        $this->db->insert(self::TABLE, $post);
        return $this->db->insert_id();
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * User_mdl::get()
     * 获取单个用户
     * @param mixed $select
     * @param mixed $value
     * @param string $key
     * @param array $where
     * @return
     */
    public function get($select = '*', $value, $key = 'uid', $where = array()) 
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
     * Post_mdl::update()
     * 更新用户
     * @param mixed $post
     * @param mixed $id
     * @return void
     */
    public function update($post, $id) 
    {
        if ($post['password'] == '') unset($post['password']);
        if (strlen($post['username']) < 4 && strlen($post['username']) > 20) return -1; //用户名长度不符
        if (!preg_match('/^[\w]+$/', $post['username'])) return -2; //用户名格式不正确
        if (!preg_match('/^[\w]+@[a-zA-Z0-9]+.+[a-zA-Z]$/', $post['usermail'])) return -3; //邮箱格式不正确
        
        $this->db->where_not_in('uid', $id);
        $this->db->where('username', $post['username']);
        if ($this->db->get(self::TABLE)->num_rows) return -4; //用户名已经存在
        
        $this->db->where_not_in('uid', $id);
        $this->db->where('usermail', $post['usermail']);
        if ($this->db->get(self::TABLE)->num_rows) return -5; //用户邮箱已经存在
        
        if (isset($post['password'])) $post['password'] = md5($post['password']. $this->encryption_key);
        
        $this->db->update(self::TABLE, $post, array('uid' => $id));
        return $this->db->affected_rows();
    }   
     
    // ------------------------------------------------------------------------
        
    /**
     * Post_mdl::del()
     * 删除用户
     * @param mixed $id
     * @return void
     */
    public function del($id) 
    {
        if (is_array($id)) {
            if (in_array($id, 1)) return false;
            $this->db->where_in('uid', $id);
            $this->db->delete(self::TABLE);
            return $this->db->affected_rows();
        }
        if ($id == 1) return false;
        $data = $this->get('username', $id);
        $this->db->delete(self::TABLE, array('uid' => $id));
        return $data;
    }
        
    // ------------------------------------------------------------------------
    
    /**
     * User_mdl::get_by_uids()
     * 根据用户ID批量获取用户信息
     * @param mixed $uids
     * @param mixed $select
     * @return
     */
    public function get_by_uids($uids, $select = '*') 
    {
        if (!$uids) return false;
        
        if (!is_array($uids)) {
            $uids = explode(',', $uids);
        }
        
        $this->db->select($select);
        $this->db->where_in('uid', $uids);
        $data = $this->db->get(self::TABLE)->result_array();
        if (!$data) return false;
        foreach ($data as $line) {
            $new_uids[$line['uid']] = $line;        
        }
        return $new_uids;
    }

    // ------------------------------------------------------------------------

    /**
     * User_mdl::checkuser()
     * 检测用户信息是否存在
     * @param string $key
     * @param mixed $value
     * @return
     */
    public function checkuser($key = 'username', $value) 
    {
        $this->db->select('uid');
        $this->db->limit(1);
        return $this->db->get_where(self::TABLE, array($key => $value))->num_rows();
    }
        
    // ------------------------------------------------------------------------

    /**
     * User_mdl::login()
     * 用户登录
     * @param mixed $username
     * @param mixed $password
     * @param string $expired
     * @return
     */
    public function login($username, $password, $expired = '') 
    {
        $this->load->library('encrypt');
        $expired = $expired ? $expired : $this->config->item('userlogin_expired');
        $user = $this->db->get_where(self::TABLE, array('username' => $username, 'password' => md5($password. $this->encryption_key)))->row_array();

        if (count($user)) {
            if ($user['status'] == 0) {
                return array('errorcode' => -1); // 用户被禁止
            }
            $now = mktime();
            $this->input->set_cookie($this->userlogin_cookiename, $this->encrypt->encode("$user[uid]\t$user[username]\t$user[usermail]\t$now\t$expired"), $expired);
            $this->db->update(self::TABLE, array('logintime' => date('Y-m-d H:i:s'), 'loginip' => $this->input->ip_address(), 'logedtime' => $user['logintime'], 'logedip' => $user['loginip'], 'logincount' => $user['logincount'] + 1), array('uid' => $user['uid']));
            return array('errorcode' => 0, 'user' => $user);  //登录成功
        } else {
            if ($this->checkuser('username', $username)) {
                return array('errorcode' => -2); //密码错误
            } 
            return array('errorcode' => -3); //用户名不存在
        }
    } 
    
    // ------------------------------------------------------------------------
    
    /**
     * User_mdl::loginout()
     * 注销登录
     * @return void
     */
    public function loginout() 
    {
        $this->input->set_cookie($this->userlogin_cookiename, '');
    }

    // ------------------------------------------------------------------------

    /**
     * User_mdl::checklogin()
     * 检测是否登录
     * @return void
     */
    public function checklogin()
    {
        if (!$this->uid) {
            show_message('请先登录','admin/login?refer='.current_url());
        }
    }    

    // ------------------------------------------------------------------------
    
    /**
     * User_mdl::checkpurview()
     * 权限检测
     * @param integer $group
     * @return void
     */
    public function checkpurview($group = 1) 
    {
        $this->checklogin();
        $u = $this->get('group', $this->uid);
        if (!count($u) || $u > $group) {
            admintip('error:抱歉，您没有此操作权限！');
        }
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * User_mdl::auth()
     * 验证登录信息
     * @return void
     */
    public function auth() 
    {
        if ($this->input->cookie($this->userlogin_cookiename)) {
            $this->load->library('encrypt');
            $u = $this->encrypt->decode($this->input->cookie($this->userlogin_cookiename));
            $user = explode("\t", $u);
            if (count($user) == 5 && is_numeric($user[0]) && mktime() - $user[4] < $user[3]) {
                $this->uid = $user[0];
                $this->username = $user[1];
                $this->usermail = $user[2];
                return true;
            }
        }
    }
    
    // ------------------------------------------------------------------------ 
    
    public function get_userlog_list($array = array()) {
        
        $this->types = array(1 => '操作日志', 2 => '登录日志');
        
        $array = $array && count($array) ? array_diff($array, array('')) : array();
        
        //type
        if (isset($array['type'])) {
            $sql[] = 'type = '.$array['type'];
        }
        
        //uid
        if (isset($array['uid'])) {
            $sql[] = self::TABLE_LOG.'.uid = '.$array['uid'];
        }
        
        //msg
        if (isset($array['msg'])) {
            $sql[] = 'msg LIKE \'%'.$array['uid'].'%\'';
        }     
        
        //page
        $page = isset($array['page']) ? $array['page'] : 1;
        
        //limit
        $limit = isset($array['limit']) ? $array['limit'] : 20;
        
        //offset
        $offset = ($page - 1) * $limit;
        
        //orderby
        $orderby = isset($array['orderby']) ? $array['orderby'] : 'id DESC';
        
        //计算总数
        $this->db->select('id');
        isset($sql) && $this->db->where(implode(' AND ', $sql));
        $return['total'] = $this->db->get(self::TABLE_LOG)->num_rows();
        
        //输出列表
        $this->db->select(self::TABLE_LOG.'.*, '.self::TABLE.'.username');
        $this->db->from(self::TABLE_LOG);
        $this->db->join(self::TABLE, self::TABLE.'.uid = '.self::TABLE_LOG.'.uid', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by($orderby);
        isset($sql) && $this->db->where(implode(' AND ', $sql));
        
        $return['list'] = $this->db->get()->result_array();
        
        return $return;        
    }   
    
    // ------------------------------------------------------------------------
    
    /**
     * User_mdl::userlog_add()
     * 插入用户日志
     * @param mixed $msg
     * @param integer $type
     * @param string $uid
     * @return void
     */
    public function userlog_add($msg, $type = 1, $uid = '') 
    {
        $this->db->insert(self::TABLE_LOG, array('uid' => $uid ? $uid : $this->uid, 'msg' => $msg, 'ip' => $this->input->ip_address(), 'time' => date('Y-m-d H:i:s'), 'type' => $type));
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * User_mdl::userlog_del()
     * 删除用户日志
     * @param mixed $id
     * @return
     */
    public function userlog_del($id) 
    {
        if (is_array($id)) {
            $this->db->where_in('id', $id);
            $this->db->delete(self::TABLE_LOG);
            return true;
        }
        $this->db->delete(self::TABLE_LOG, array('id' => $id));
        return true;
    }

    
  
}

/* End of file user.php */
/* Location: ./application/models/user.php */
