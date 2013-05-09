<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Post_mdl
 * 文章
 * @package   
 * @author Auror
 * @copyright owncms
 * @version 2013
 * @access public
 */
class Post_mdl extends CI_Model
{
    const TABLE = 'post';
    const TABLE_USER = 'user';
    const TABLE_TAG = 'tag';
    const TABLE_CATEGORY = 'category';
    const TABLE_COMMENT = 'comment';
    
    public $templates = array('post' => '默认[post]');
    
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
     * Post_mdl::get_list()
     * 文章列表
     * @param array $array
     * @return
     */
    public function get_list($array = array()) 
    {   
        $array = $array && count($array) ? array_diff($array, array('')) : array();
        
        //flag
        if (isset($array['flag'])) {
            $sql[] = self::TABLE.'.flag LIKE \'%'.$array['flag'].'%\'';
        }
        
        //tag
        if (isset($array['tag'])) {
            $tagid = is_numeric($array['tag']) ? $array['tag'] : $this->get_tagid_by_tag($array['tag']);
            $sql[] = self::TABLE.'.tag LIKE \'%,'.$tagid.',%\'';
        }
        
        //uid
        if (isset($array['uid'])) {
            $sql[] = self::TABLE.'.uid = '.$array['uid'];
        }
        
        //category
        if (isset($array['category'])) {
            $this->load->model('Category_mdl');
            if (is_numeric($array['category'])) {
                $cateid = $this->Category_mdl->get('id', $array['category'], 'id');
            } else {
                $cateid = $this->Category_mdl->get('id', $array['category'], 'slug');
            }
            
            $cateids = getSonCategory($this->Category_mdl->get_list(), $cateid ? $cateid : 0);
            $sql[] = self::TABLE.'.category IN ('.implode(',', $cateids).')';
        }
        
        //title
        if (isset($array['title'])) {
            $sql[] = self::TABLE.'.title LIKE \'%'.$array['title'].'%\'';
        }
        
        //ishidden
        if (isset($array['ishidden'])) {
            $sql[] = self::TABLE.'.ishidden = '.$array['ishidden'];
        }
        
        //posttime
        if (isset($array['posttime'])) {
            $sql[] = $array['posttime'] == true ? self::TABLE.'.posttime < \''.date('Y-m-d H:i:s').'\'' : self::TABLE.'.posttime < \''.$array['posttime'].'\'';
        }
        
        //select
        $select = isset($array['select']) ? $array['select'] : '*';
        
        //page
        $page = isset($array['page']) && $array['page'] > 0 ? $array['page'] : 1;
        
        //limit
        $limit = isset($array['limit']) ? $array['limit'] : 20;
        
        //offset
        $offset = ($page - 1) * $limit;
        
        //orderby
        $orderby = isset($array['orderby']) ? $array['orderby'] : self::TABLE.'.sortrank DESC, '.self::TABLE.'.id DESC';
        
        //onlylist
        if (!isset($array['onlylist'])) {
            //计算总数
            $this->db->select('id');
            isset($sql) && $this->db->where(implode(' AND ', $sql));
            $return['total'] = $this->db->get(self::TABLE)->num_rows();            
        }
        
        //输出列表
        $this->db->select(add_table_prefix(self::TABLE, $select).','.self::TABLE_CATEGORY.'.channeltype'.','.self::TABLE_USER.'.username');
        $this->db->from(self::TABLE);
        $this->db->join(self::TABLE_CATEGORY, self::TABLE.'.category = '.self::TABLE_CATEGORY.'.id', 'left');
        $this->db->join(self::TABLE_USER, self::TABLE.'.uid = '.self::TABLE_USER.'.uid', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by($orderby);
        isset($sql) && $this->db->where(implode(' AND ', $sql));
        
        $return['list'] = $this->db->get()->result_array();
        
        return $return;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Post_mdl::add()
     * 新增文章
     * @param mixed $post
     * @return
     */
    public function add($post) 
    {
        $post = array_diff($post, array(''));
        $post['flag'] = isset($post['flag']) ? implode(',', $post['flag']) : '';
        $post['uid'] = $this->User_mdl->uid;
        $post['tag'] = $this->_add_tag($post['tag']);
        if ($this->db->insert(self::TABLE, $post)) {
            return $this->db->insert_id();
        }
        return false;
    }

    // ------------------------------------------------------------------------
    
    /**
     * Post_mdl::get()
     * 获取文章
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
     * Post_mdl::update()
     * 更新文章
     * @param mixed $post
     * @param mixed $id
     * @return void
     */
    public function update($post, $id) 
    {
        clear_this_cache($id);
        $post['flag'] = isset($post['flag']) ? implode(',', $post['flag']) : '';
        $post['modifytime'] = date('Y-m-d H:i:s');
        $post['tag'] = $this->_add_tag($post['tag']);
        if ($this->db->update(self::TABLE, $post, array('id' => $id))) {
            return $this->db->affected_rows();
        }
        return false; 
    }
        
    // ------------------------------------------------------------------------
        
    /**
     * Post_mdl::del()
     * 删除文章
     * @param mixed $id
     * @return void
     */
    public function del($id) 
    {
        if (is_array($id)) {
            $this->db->where_in('id', $id);
            $posts = $this->db->select('slug,category')->get(self::TABLE)->result_array();
            foreach ($posts as $line) {
                clear_this_cache($id); //删除缓存
            }
            $this->db->where_in('pid', $id)->delete(self::TABLE_COMMENT); //删除文章评论
            $this->db->where_in('id', $id);
            $this->db->delete(self::TABLE);
            return $this->db->affected_rows();
        }
        $data = $this->get('title,slug', $id);
        clear_this_cache($id); //删除缓存
        $this->db->delete(self::TABLE_COMMENT, array('pid' => $id)); //删除文章评论
        $this->db->delete(self::TABLE, array('id' => $id));
        return $data;
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * Post_mdl::update_field()
     * 更新文章字段
     * @param mixed $filed
     * @param mixed $id
     * @param number $value 如果设置此项，则更新以此为标准
     * @return
     */
    public function update_field($filed, $id, $value = '') 
    {
		$this->db->where('id', $id);
		if (is_numeric($value)) {
			$this->db->set($filed, $value);
		} else {
			$this->db->set($filed, $filed.' + 1', FALSE); 
		}
		$this->db->update(self::TABLE);
		return $this->db->affected_rows();
    }
    
    // ------------------------------------------------------------------------
        
    /**
     * Post_mdl::get_near_post()
     * 获取上一个 下一个文章
     * @param mixed $id
     * @param string $select
     * @param string $where
     * @return
     */
    public function get_near_post($id, $select = '*', $where = '*')
    {
        $this->db->select($select);
        $this->db->order_by('id ASC');
        if ($where == 'next') {
            $return['next'] = $this->db->get_where(self::TABLE, array('id > ' => $id), 1)->row_array();
        } elseif ($where == 'prev') {
            $this->db->order_by('id DESC');
            $return['prev'] = $this->db->get_where(self::TABLE, array('id < ' => $id), 1)->row_array();
        } else {
            $return['next'] = $this->db->get_where(self::TABLE, array('id > ' => $id), 1)->row_array();
            $this->db->select($select);
            $this->db->order_by('id DESC');
            $return['prev'] = $this->db->get_where(self::TABLE, array('id < ' => $id), 1)->row_array();
        }
        return $return;
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * Post_mdl::_addtag()
     * 添加标签，并返回数组
     * @param mixed $tag
     * @return
     */
    private function _add_tag($tag) 
    {
        if($tag) {
            $tag = trim($tag);
            $tag = str_replace('，', ',', $tag);
            $tag = str_replace(' ', ',', $tag);
            $tags = explode(',', $tag);
            $tags = array_filter($tags);
            $tags = array_unique($tags);
            
            $this->db->where_in('tag', $tags);
            $have = $this->db->get(self::TABLE_TAG)->result_array();
            $haved = array();
            if ($have) {
                foreach ($have as $line) {
                    $haved[] = $line['tag'];
                }
            }
            
            $left = array_diff($tags, $haved);
            if (count($left)) {
                $sql = implode("'),('", $left);
                $sql = "('" . $sql . "')";
                $this->db->query('INSERT INTO '.self::TABLE_TAG.' (tag) VALUES '.$sql);
            }
            
            $this->db->where_in('tag', $tags);
            $query = $this->db->get(self::TABLE_TAG)->result_array();
            foreach ($query as $line) {
                $return[] = $line['id'];
            }
            return ','.implode(',', $return).',';
        }
        return '';
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * Post_mdl::get_taglist()
     * 获取所有标签
     * @param mixed $array
     * @return
     */
    public function get_taglist($array = array()) 
    {
        $array = $array && count($array) ? array_diff($array, array('')) : array();
        
        //select
        $select = isset($array['select']) ? $array['select'] : '*';
        
        //page
        $page = isset($array['page']) && $array['page'] > 0 ? $array['page'] : 1;
        
        //limit
        $limit = isset($array['limit']) ? $array['limit'] : 20;
        
        //offset
        $offset = ($page - 1) * $limit;
        
        //orderby
        $orderby = isset($array['orderby']) ? $array['orderby'] : 'id DESC';
        
        
        //计算总数
        $this->db->select('id');
        isset($sql) && $this->db->where(implode(' AND ', $sql));
        $return['total'] = $this->db->get(self::TABLE_TAG)->num_rows();
        
        //输出列表
        $this->db->select($select);
        $this->db->limit($limit, $offset);
        $this->db->order_by($orderby);
        isset($sql) && $this->db->where(implode(' AND ', $sql));
        
        $return['list'] = $this->db->get(self::TABLE_TAG)->result_array();
        
        return $return;
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * Post_mdl::get_taglist_by_tagids()
     * 获取标签，并返回数组
     * @param mixed $tag
     * @return
     */
    public function get_taglist_by_tagids($tagids) 
    {
        if($tagids) {
            if (!is_array($tagids)) $tagids = array_filter(explode(',', $tagids));
            $this->db->where_in('id', $tagids);
            $data = $this->db->get(self::TABLE_TAG)->result_array();
            if (!$data) return false;
            foreach ($data as $line) {
                $new_data[$line['id']] = $line;
            }
            return $new_data;
        }
        return false;
    }
    
    // ------------------------------------------------------------------------
    
    /**
     * Post_mdl::get_tagid_by_tag()
     * 根据标签，返回标签ID
     * @param mixed $tag
     * @return
     */
    public function get_tagid_by_tag($tag) 
    {
        $result = $this->db->get_where(self::TABLE_TAG, array('tag' => $tag))->row_array();
        return $result ? $result['id'] : false;
    } 
    
    /**
     * Post_mdl::get_tag_list()
     * 获取热门标签
     * @param integer $limit
     * @return void
     */
    public function get_hot_tag($limit = 10){
        $posts = $this->get_list(array('select' => 'tag', 'limit' => '10000'));
        $a = '';
        $b = $c = $d = array();
        if (count($posts)) {
            foreach ($posts['list'] as $line) {
                if ($line['tag'] != '') {
                    $a .= $line['tag'];
                }
            }
            $a = str_replace(',,', ',', $a);
            $b = array_filter(explode(',', $a));
            $b = array_count_values($b);
            arsort($b);
            $b = array_slice($b, 0, $limit, true);
            $c = array_keys($b);
            $tags = $this->get_taglist_by_tagids($c);
            foreach ($b as $key => $value) {
                $d[] = array('id' => $key, 'total' => $value, 'tag' => $tags[$key]['tag']);
            }
            return $d;
        }
        return array();
        
    }       
    

}

/* End of file post_mdl.php */
/* Location: ./application/models/post_mdl.php */
