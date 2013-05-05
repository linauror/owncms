<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Siteconfig_mdl
 * 网站设置
 * @package   
 * @author Auror
 * @copyright owncms
 * @version 2013
 * @access public
 */
class Siteconfig_mdl extends CI_Model
{
    const TABLE = 'siteconfig';
    
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
     * Siteconfig_mdl::get_list()
     * 获取所有变量
     * @param mixed $array
     * @param boolen $onlyvalue 是否只输出value
     * @return
     */
    public function get_list($array = array(), $onlyvalue = false) 
    {
        $array = $array && count($array) ? array_diff($array, array('')) : array();
        
        //select
        if (isset($array['select']) && $array['select'] <> '*') {
            $this->db->select($array['select']);
        }
        
        //varname
        if (isset($array['varname'])) {
            $this->db->where_in('varname', explode(',', $array['varname']));
        }        
        
        $data = $this->db->get(self::TABLE)->result_array();
        
        foreach ($data as $line) {
            $return[$line['varname']] = $onlyvalue ? $line['value'] : $line;
        }
        return $return;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Siteconfig_mdl::add()
     * 新增变量
     * @param mixed $post
     * @return
     */
    public function add($post) 
    {
        $post = array_diff($post, array(''));
        $check = $this->db->get_where(self::TABLE, array('varname' => $post['varname']))->num_rows();
        if ($check) {
            return false;
        }
        $this->db->insert(self::TABLE, $post);
        return $this->db->insert_id();
    }

    // ------------------------------------------------------------------------
    
    /**
     * Siteconfig_mdl::get()
     * 获取变量
     * @param string $select
     * @param string $value
     * @param string $key
     * @param array $where
     * @return
     */
    public function get($select = '*', $value, $key = 'varname', $where = array()) 
    {
        if (!$value) return false;
        $this->db->limit(1);
        $this->db->select($select);
        count($where) && $this->db->where($where);
        $data = $this->db->get_where(self::TABLE, array($key => $value))->row_array();
        if ($select <> '*' && !strstr($select, ',')) {
            return $data[$select];
        }
        return $data;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Siteconfig_mdl::update()
     * 更新变量
     * @param mixed $post
     * @return void
     */
    public function update($post) 
    {
        foreach ($post as $key => $value) {
            $this->db->update(self::TABLE, array('value' => $value), array('varname' => $key));
        }
    }
    
    // ------------------------------------------------------------------------
        
    /**
     * Siteconfig_mdl::del()
     * 删除变量
     * @param mixed $id
     * @return void
     */
    public function del($id) 
    {
        if ($id < 5) {
            return false;
        }
        $data = $this->get('varname', $id, 'id');
        $this->db->delete(self::TABLE, array('id' => $id));
        return $data;
    }

}

/* End of file siteconfig.php */
/* Location: ./application/models/siteconfig.php */
