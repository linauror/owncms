<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * friendlink_mdl
 * 友情链接
 * @package   
 * @author Auror
 * @copyright owncms
 * @version 2013
 * @access public
 */
class Friendlink_mdl extends CI_Model
{
    const TABLE = 'friendlink';
    
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
     * Friendlink_mdl::get_list()
     *  获取所有友情链接
     * @return
     */
    public function get_list($array = array()) 
    {
        $array = $array && count($array) ? array_diff($array, array('')) : array();

        //ishidden
        if (isset($array['ishidden'])) {
            $this->db->where('ishidden', $array['ishidden']);
        }        
        
        //orderby
        $orderby = isset($array['orderby']) ? $array['orderby'] : 'sortrank DESC, id DESC'; 
        $this->db->order_by($orderby);
              
        return $this->db->get(self::TABLE)->result_array();
    }

    // ------------------------------------------------------------------------
    
    /**
     * friendlink_mdl::add()
     * 新增友情链接
     * @param mixed $post
     * @return
     */
    public function add($post) 
    {
        $post = array_diff($post, array(''));
        $this->db->insert(self::TABLE, $post);
        return $this->db->insert_id();
    }

    // ------------------------------------------------------------------------
    
    /**
     * Friendlink_mdl::get()
     * 获取变量
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
     * Friendlink_mdl::update()
     * 更新链接
     * @param mixed $post
     * @param mixed $id
     * @param array $where
     * @return void
     */
    public function update($post, $id, $where = array()) 
    {
        if ($this->db->update(self::TABLE, $post, array_merge(array('id' => $id), $where))) {
            return $this->db->affected_rows();
        }
        return false;
    }
    
    // ------------------------------------------------------------------------
        
    /**
     * friendlink_mdl::del()
     * 删除变量
     * @param mixed $id
     * @param array $where
     * @return void
     */
    public function del($id, $where = array()) 
    {
        if (is_array($id)) {
            $this->db->where_in('id', $id);
            count($where) && $this->db->where($where);
            $this->db->delete(self::TABLE);
            return $this->db->affected_rows();
        }
        $data = $this->get('title,url', $id);
        $this->db->delete(self::TABLE, array_merge(array('id' => $id), $where));
        return $data;
    }

}

/* End of file friendlink_mdl.php */
/* Location: ./application/models/friendlink_mdl.php */
