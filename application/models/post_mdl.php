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
    const TABLE_RELATION = 'relation';
    
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
        $tag_join = $tag_where = array();
        if (isset($array['tag'])) {
            $tagid = is_numeric($array['tag']) ? $array['tag'] : $this->get_tagid_by_tag($array['tag']);
            $tag_join = array(self::TABLE_RELATION, self::TABLE . '.id=' . self::TABLE_RELATION . '.key', 'left');
            $tag_where = array(self::TABLE_RELATION . '.value' => $tagid, self::TABLE_RELATION . '.type' => 'pt');
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
            $this->db->select(self::TABLE . '.id');
            if ($tag_join) {
                $this->db->join($tag_join[0], $tag_join[1], $tag_join[2]); 
                $this->db->where($tag_where);
            }
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
        if ($tag_join) {
            $this->db->join($tag_join[0], $tag_join[1], $tag_join[2]); 
            $this->db->where($tag_where);
        }
        
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
        $post['tag'] = isset($post['tag']) ? implode(',', $this->_add_tag($post['tag'])) : '';
        if ($this->db->insert(self::TABLE, $post)) {
            $inserId = $this->db->insert_id();
            $post['tag'] ? $this->addRelation($inserId, $post['tag']) : '';
            return $inserId;
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
     * @param array $where
     * @return void
     */
    public function update($post, $id, $where = array()) 
    {
        $post['flag'] = isset($post['flag']) ? implode(',', $post['flag']) : '';
        $post['tag'] = isset($post['tag']) ? implode(',', $this->_add_tag($post['tag'])) : '';
        $post['modifytime'] = date('Y-m-d H:i:s');
        if ($this->db->update(self::TABLE, $post, array_merge(array('id' => $id), $where))) {
            $affected_rows = $this->db->affected_rows();
            $post['tag'] ? $this->updateRelation($id, $post['tag']) : '';
            return $affected_rows;
        }
        return false; 
    }
        
    // ------------------------------------------------------------------------
        
    /**
     * Post_mdl::del()
     * 删除文章
     * @param mixed $id
     * @param array $where
     * @return void
     */
    public function del($id, $where = array()) 
    {
        if (is_array($id)) {
            $this->db->where_in('id', $id);
            count($where) && $this->db->where($where);
            $posts = $this->db->select('slug,category')->get(self::TABLE)->result_array();
            $this->db->where_in('pid', $id)->delete(self::TABLE_COMMENT); //删除文章评论
            $this->db->where_in('id', $id);
            count($where) && $this->db->where($where);
            $this->db->delete(self::TABLE);
            return $this->db->affected_rows();
        }
        $data = $this->get('title,slug', $id);
        $this->db->delete(self::TABLE_COMMENT, array('pid' => $id)); //删除文章评论
        $this->db->delete(self::TABLE, array_merge(array('id' => $id), $where));
        $this->DelRelation($id); // 删除关系表数据
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
     * Post_mdl::get_tags_by_posts()
     * 通过文章ID获取标签信息
     * @param mixed $postIds
     * @return void
     */
    public function get_tags_by_posts($postIds = array()) {
        if (is_array($postIds)) {
            $ids = implode(',', $postIds);
        }
        $tagids = $this->getRelation($ids);
        if ($tagids) {
            return $this->get_taglist_by_tagids($tagids);
        }
        return false;
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
            
            $tags = array_map(function($v){return strtolower($v);}, $tags);
            
            $this->db->where_in('tag', $tags);
            $have = $this->db->get(self::TABLE_TAG)->result_array();
            $haved = getSubByKey($have, 'tag');
            
            $left = array_diff($tags, $haved);
            if (count($left)) {
                $sql = implode("'),('", $left);
                $sql = "('" . $sql . "')";
                $this->db->query('INSERT INTO '.self::TABLE_TAG.' (tag) VALUES '.$sql);
            }
            
            $this->db->where_in('tag', $tags);
            $query = $this->db->get(self::TABLE_TAG)->result_array();
            return getSubByKey($query, 'id');
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
        $return['total'] = $this->db->get(self::TABLE_TAG)->num_rows();
        
        //输出列表
        $this->db->select($select);
        $this->db->limit($limit, $offset);
        $this->db->order_by($orderby);
        
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
    
    // ------------------------------------------------------------------------    
    
    /**
     * Post_mdl::get_tag_list()
     * 获取热门标签
     * @param integer $limit
     * @return void
     */
    public function get_hot_tag($limit = 10)
    {   
        $tags = $this->db->query('SELECT `value`, COUNT(`value`) AS `total` FROM ' . self::TABLE_RELATION . ' WHERE `type` = \'pt\' GROUP BY `value` ORDER BY `total` DESC LIMIT ' . $limit)->result_array();
        if ($tags) {
            return $this->get_taglist_by_tagids(getSubByKey($tags, 'value'));
        }
        return array();
    }
    
    // ------------------------------------------------------------------------ 
    
    /**
     * Post_mdl::getRelation()
     * 通过关系表或者值
     * @param integer $id
     * @param string $col
     * @param string $type
     * @return
     */
    public function getRelation($id = array(), $col = 'key', $type = 'pt') {
        if (! is_array($id)) {
            $id = explode(',', $id);
        }
        $this->db->where_in($col, $id);
        $relation = $this->db->get_where(self::TABLE_RELATION, array('type' => $type))->result_array();
        if ($relation) {
            return getSubByKey($relation, $col == 'key' ? 'value' : 'key');
        }
        return false;
    }
      
    // ------------------------------------------------------------------------ 
    
    /**
     * Post_mdl::addRelation()
     * 插入关系表
     * @param integer $keyId
     * @param mixed $valueIds
     * @param string $type
     * @return
     */
    public function addRelation($keyId = 0, $valueIds = array(), $type = 'pt') 
    {
        if (! $keyId || ! $valueIds || ! $type) {
            return false;
        }
      
        if (! is_array($valueIds)) {
            $valueIds = explode(',', $valueIds);
        }

        $data = array();
        foreach ($valueIds as $key => $value) {
            $data[$key]['key'] = $keyId;
            $data[$key]['value'] = $value;
            $data[$key]['type'] = $type;
        }
        
        $this->db->insert_batch(self::TABLE_RELATION, $data);
    }

	/**
	 * Post_mdl::updateRelation()
	 * 关系表更新
	 * @param integer $keyId
	 * @param mixed $valueIds
	 * @param string $type
	 * @return
	 */
	public function updateRelation($keyId = 0, $valueIds = array(), $type = 'pt') 
    {
        if (! $keyId || ! $valueIds || ! $type) {
            return false;
        }

        if (! is_array($valueIds)) {
            $valueIds = explode(',', $valueIds);
        }        
        
		$agoIdsArr = $this->db->get_where(self::TABLE_RELATION, array('key' => $keyId, 'type' => $type))->result_array();
		$agoIds = getSubByKey($agoIdsArr, 'value');

        // 删除多余的
		$diffArr1 = array_diff($agoIds, $valueIds);
		if ($diffArr1) {
			$this->db->where(array('key' => $id, 'type' => $type));
			$this->db->where_in('value', $diffArr1);
			$this->db->delete(self::TABLE_RELATION);
		}
        
		//增加新的
		$diffArr2 = array_diff($valueIds, $agoIds);
		if ($diffArr2) {
            $this->addRelation($keyId, $diffArr2, $type);
		}
        
        return true;
	}       
    
    /**
     * Post_mdl::DelRelation()
     * 删除关联关系
     * @param integer $id
     * @param string $col
     * @param string $type
     * @return void
     */
    public function DelRelation($id = 0, $col = 'key', $type = 'pt') {
        $this->db->where(array($col => $id, 'type' => $type));
        $this->db->delete(self::TABLE_RELATION);
        return $this->db->affected_rows();
    }

}

/* End of file post_mdl.php */
/* Location: ./application/models/post_mdl.php */
