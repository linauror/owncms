<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * page_mdl
 * 单页文档
 * @package   
 * @author Auror
 * @copyright owncms
 * @version 2013
 * @access public
 */
class Page_mdl extends CI_Model
{
    const TABLE = 'page';
    const TABLE_USER = 'user';
    public $templates = array('page' => '默认[page]');
    
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
     * Page_mdl::get_list()
     *  获取所有单页文档
     * @return
     */
    public function get_list() 
    {
        $this->db->select(self::TABLE.'.*, '.self::TABLE_USER.'.username AS author');
        $this->db->from(self::TABLE);
        $this->db->join(self::TABLE_USER, self::TABLE_USER.'.uid = '.self::TABLE.'.uid', 'left');
        return $this->db->get()->result_array();
    }

    // ------------------------------------------------------------------------
    
    /**
     * page_mdl::add()
     * 新增单页文档
     * @param mixed $post
     * @return
     */
    public function add($post) 
    {
        $post = array_diff($post, array(''));
        if (!$this->get('id', $post['slug'], 'slug')) {
            $this->db->select_max('id', 'maxid');
            $maxidArray = $this->db->get(self::TABLE)->row_array();
            $maxid = $maxidArray ? $maxidArray['maxid'] + 1 : 1;
            
            $post['slug'] = $post['slug'] ? $post['slug'] : $maxid;
            $post['uid'] = $this->User_mdl->uid;
            $this->db->insert(self::TABLE, $post);
            return $this->db->insert_id();
        } 
        return false;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Page_mdl::get()
     * 获取单页文档
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
     * Page_mdl::update()
     * 更新单页文档
     * @param mixed $post
     * @param mixed $id
     * @return void
     */
    public function update($post, $id) 
    {
        $this->db->where_not_in('id', $id);
        $this->db->where('slug', $post['slug']);
        $check = $this->db->get(self::TABLE)->num_rows();
        if (!$check) {
            clear_this_cache($post['slug'], 'page');
            $post['modifytime'] = date('Y-m-d H:i:s');
            $this->db->update(self::TABLE, $post, array('id' => $id));
            return $this->db->affected_rows();
        }
        return false; 
    }

    // ------------------------------------------------------------------------
        
    /**
     * page_mdl::del()
     * 删除单页文档
     * @param mixed $id
     * @return void
     */
    public function del($id) 
    {
        if (is_array($id)) {
            $this->db->where_in('id', $id);
            $pages = $this->db->select('slug')->get(self::TABLE)->result_array();
            foreach ($pages as $line) {
                clear_this_cache($line['slug'], 'page');
            }
            $this->db->delete(self::TABLE);
            return $this->db->affected_rows();
        }
        $data = $this->get('title,slug', $id);
        clear_this_cache($data['slug'], 'page');
        $this->db->delete(self::TABLE, array('id' => $id));
        return $data;
    }

}

/* End of file page_mdl.php */
/* Location: ./application/models/page_mdl.php */
