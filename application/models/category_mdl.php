<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Category_mdl
 * 分类目录
 * @package   
 * @author Auror
 * @copyright owncms
 * @version 2013
 * @access public
 */
class Category_mdl extends CI_Model
{
    const TABLE = 'category';
    const TABLE_POST = 'post';
    
    public $channeltype = array('post' => '默认[post]');
    public $tempindex = array('category' => '默认[category]');
    public $temparticle = array('post' => '默认[post]');
    
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
     * Category_mdl::get_list()
     *  获取所有分类目录
     * @return
     */
    public function get_list($array = array()) 
    {
        //select
        $select = isset($array['select']) ? $array['select'] : '*';
        
        //orderby
        $orderby = isset($array['orderby']) ? $array['orderby'] : self::TABLE.'.id ASC';
        
        //groupby
        $groupby = isset($array['groupby']) ? $array['groupby'] : self::TABLE.'.id';
        
        //postcount
        if (isset($array['postcount'])) {
            $this->db->select(add_table_prefix(self::TABLE, $select).', COUNT('.self::TABLE_POST.'.id) AS postcount');
            $this->db->from(self::TABLE);
            $this->db->join(self::TABLE_POST, self::TABLE_POST.'.category = '.self::TABLE.'.id', 'left');            
        } else {
            $this->db->select($select)->from(self::TABLE);
        }       
        $this->db->order_by($orderby);
        $this->db->group_by($groupby);
        return $this->db->get()->result_array();
    }

    // ------------------------------------------------------------------------
    
    /**
     * Category_mdl::add()
     * 新增分类目录
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
            $this->db->insert(self::TABLE, $post);
            return $this->db->insert_id();
        } 
        return false;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Category_mdl::get()
     * 获取分类目录
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
     * Category_mdl::update()
     * 更新分类目录
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
            $this->db->update(self::TABLE, $post, array('id' => $id));
            return $this->db->affected_rows();
        }
        return false; 
    }
    
    // ------------------------------------------------------------------------
        
    /**
     * Category_mdl::del()
     * 删除分类目录
     * @param mixed $id
     * @return void
     */
    public function del($id) 
    {
        if (is_array($id)) {
            $this->db->where_in('id', $id);
            $this->db->delete(self::TABLE);
            return $this->db->affected_rows();;
        }
        $data = $this->get('typename, slug', $id);
        $this->db->delete(self::TABLE, array('id' => $id));
        return $data;
    }

}

/* End of file category_mdl.php */
/* Location: ./application/models/category_mdl.php */
