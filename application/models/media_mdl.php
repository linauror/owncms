<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Media_mdl
 * 媒体模块
 * @package   
 * @author Auror
 * @copyright owncms
 * @version 2013
 * @access public
 */
class Media_mdl extends CI_Model
{

    const TABLE = 'media';
    const TABLE_USER = 'user';

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
    }

    // ------------------------------------------------------------------------
    
    /**
     * Media_mdl::get_list()
     * 媒体列表
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
        
        //suffix
        if (isset($array['suffix'])) {
            $sql[] = 'suffix = \''.$array['suffix'].'\'';
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
        $orderby = isset($array['orderby']) ? $array['orderby'] : 'id DESC';
        
        //onlylist 只输出list
        if (!isset($array['onlylist'])) {
            //计算总数
            $this->db->select('id');
            isset($sql) && $this->db->where(implode(' AND ', $sql));
            $return['total'] = $this->db->get(self::TABLE)->num_rows();            
        }
        
        //输出列表
        $this->db->select(add_table_prefix(self::TABLE, $select).','.self::TABLE_USER.'.username');
        $this->db->from(self::TABLE);
        $this->db->join(self::TABLE_USER, self::TABLE.'.uid = '.self::TABLE_USER.'.uid');
        $this->db->limit($limit, $offset);
        $this->db->order_by($orderby);
        isset($sql) && $this->db->where(implode(' AND ', $sql));
        
        $return['list'] = $this->db->get()->result_array();
        
        return $return;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Media_mdl::add()
     * 新增媒体
     * @param mixed $post
     * @return
     */
    public function add($post) 
    {
        $post = array_diff($post, array(''));
        $post['uid'] = $this->User_mdl->uid;              
        $this->db->insert(self::TABLE, $post);
        return $this->db->insert_id();
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * Media_mdl::get()
     * 获取单个媒体
     * @param mixed $select
     * @param mixed $value
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
     * Media_mdl::update()
     * 更新媒体
     * @param mixed $post
     * @param mixed $id
     * @return void
     */
    public function update($post, $id) 
    {
        $this->db->update(self::TABLE, $post, array('id' => $id));
        return $this->db->affected_rows();
    }
         
    // ------------------------------------------------------------------------
        
    /**
     * Media_mdl::del()
     * 删除媒体
     * @param mixed $id
     * @return void
     */
    public function del($id) 
    {
        if (is_array($id)) {
            $this->db->where_in('id', $id);
            $this->db->delete(self::TABLE);
            return $this->db->affected_rows();
        }
        $data = $this->get('title,filepath', $id);
        strstr($data['filepath'], base_url()) && @unlink(str_replace(base_url(), getcwd().'/', $data['filepath']));
        $this->db->delete(self::TABLE, array('id' => $id));
        return $data;
    }
      
}

/* End of file media_mdl.php */
/* Location: ./application/models/media_mdl.php */
