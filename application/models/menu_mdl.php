<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Menu_mdl
 * 菜单
 * @package   
 * @author Auror
 * @copyright owncms
 * @version 2013
 * @access public
 */
class Menu_mdl extends CI_Model
{
    const TABLE = 'menu';
        
    /**
     * 构造函数
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->types = array('page' => '单页文档', 'category' => '分类目录', 'jump' => '自定义链接');
        $this->targets = array('_self' => '本页面_self', '_blank' => '新页面_blank', '_top' => '顶级页面_top', '_parent' => '父页面_parent');
    }

    // ------------------------------------------------------------------------
    
    /**
     * Menu_mdl::get_list()
     *  获取所有菜单
     * @return
     */
    public function get_list($array = array()) 
    {
        //orderby
        isset($array['orderby']) ? $this->db->order_by($array['orderby']) : $this->db->order_by('sortrank DESC, id ASC');
        
        return $this->db->get(self::TABLE)->result_array();
    }

    // ------------------------------------------------------------------------
    
    /**
     * Menu_mdl::add()
     * 新增菜单
     * @param mixed $post
     * @return
     */
    public function add($post) 
    {
        $post = array_diff($post, array(''));
        if (!$this->get('id', $post['url'], 'url')) {
            $this->db->insert(self::TABLE, $post);
            return $this->db->insert_id();
        } 
        return false;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Menu_mdl::get()
     * 获取菜单
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
     * Menu_mdl::update()
     * 更新菜单
     * @param mixed $post
     * @param mixed $id
     * @param array $where
     * @return void
     */
    public function update($post, $id, $where = array()) 
    {
        $this->db->where_not_in('id', $id);
        $this->db->where('url', $post['url']);
        $check = $this->db->get(self::TABLE)->num_rows();
        if (!$check && $this->db->update(self::TABLE, $post, array_merge(array('id' => $id), $where))) {
            return $this->db->affected_rows();
        }
        return false; 
    }
    
    // ------------------------------------------------------------------------
        
    /**
     * Menu_mdl::del()
     * 删除菜单
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
        $data = $this->get('nav, url', $id);
        $this->db->delete(self::TABLE, array_merge(array('id' => $id), $where));
        return $data;
    } 

}

/* End of file menu_mdl.php */
/* Location: ./application/models/menu_mdl.php */
