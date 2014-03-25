<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    

// --------------------------------------------------------------------

/**
 * 获取此分类以上所有分类以及自己
 * @todo 
 * @param 
 * @return $array
 */
if (!function_exists('getParCategory'))
{
    function getParCategory($array, $category, $sprintf, $separator = '', $start = array())
    {
        $a = $start;
        foreach ($array as $array1) {
            if ($array1['id'] == $category) {
                $a[] = array('id' => $array1['id'], 'typename' => $array1['typename'], 'slug' => $array1['slug']);
                if ($array1['reid'] == 0) {
                    $a = array_reverse($a);
                    foreach ($a as $line) {
                        $b[] = sprintf($sprintf, $line['id'], $line['slug'], $line['typename']);
                    }
                    echo implode($separator, $b);
                } else {
                    getParCategory($array, $array1['reid'], $sprintf, $separator, $a);
                }
            }
        } 
    }
}

// --------------------------------------------------------------------

if (!function_exists('show_menu_nav'))
{
    /**
     * show_menu_nav()
     * 输出菜单
     * @param mixed $array
     * @param integer $reid
     * @param string $class
     * @return
     */
    function show_menu_nav($array, $reid = 0, $current_nav = 'index', $container_class = 'menu_container', $sub_class = 'sub_menu')
    {
        $html = '';
        foreach ($array as $line) {
            if ($line['reid'] == $reid) {
                $html .= '<li class="menu-item menu-nav-'.$line['id'].($line['id'] == get_top_nav($array, get_from_array($array, 'url', $current_nav, 'id')) ? ' current' : '').'"><a href="'.site_url($line['url']).'" target = "'.$line['target'].'">'.$line['nav'].'</a>';
                $html .= show_menu_nav($array, $line['id'], $current_nav, $container_class, $sub_class);
                $html .= '</li>';
            }
        }
        return $html ? '<ul class = "'.($reid ? $sub_class : $container_class).'">'.$html.'</ul>' : $html ;
    }
}

// --------------------------------------------------------------------

if (!function_exists('get_top_nav'))
{
    /**
     * get_top_nav()
     * 寻找顶级菜单
     * @param mixed $array
     * @param integer $reid
     * @return
     */
    function get_top_nav($array, $reid)
    {
        foreach ($array as $line) {
            if ($reid == $line['id']) {
                if ($line['reid'] == 0) {
                    return $line['id'];
                } else {
                   return get_top_nav($array, $line['reid']); 
                }
            }
        }
    }
}

// --------------------------------------------------------------------

if (!function_exists('show_comments_list'))
{
    /**
     * show_comments_list()
     * 输出评论列表
     * @param mixed $array
     * @param integer $reid
     * @param mixed $post_uid
     * @return
     */
    function show_comments_list($array, $reid = 0, $post_uid)
    {
        $html = '';
        $i = 1;
        foreach ($array as $line) {
            if ($line['reid'] == $reid) {
                $html .= '<li id="comments_id_'.$line['id'].'"><div class="comment_wrap"><div class="comment_meta"><img src="http://www.gravatar.com/avatar/'.md5(strtolower($line['usermail'])).'?s=44" class="avatar" />';
                $html .= '<p class="username">'.($line['reid'] == 0 ? '<strong>'.$i.'楼</strong> ' : '').( $line['userurl'] ? '<a href="'.(strpos($line['userurl'], 'http') === 0 ? $line['userurl'] : 'http://' . $line['userurl']).'" target="_blank"> '.$line['username'].' </a>' : $line['username']).($line['uid'] == $post_uid ? ' <span><a href="'.site_url('author/'.$line['username']).'" title ="点击查看作者所有作品">文章作者</a></span>' : '').'</p>';
                $html .= '<p class="posttime">'.$line['posttime'].'</p></div>';
                $html .= '<div class="comment_content">'.$line['content'].'</div>';
                $html .= show_comments_list($array, $line['id'], $post_uid);
                $html .= $line['reid'] == 0 ? '<div class="comment_reply_link"><a href="#respond" onclick="go_reply('.$line['id'].');">回复</a>↓</div></div>' : '';
                $html .= '</li>';
            }
            $i++;
        }
        return $html ? '<ol>'.$html.'</ol>' : $html ;
    }
}

// --------------------------------------------------------------------

    /**
     * get_from_array()
     * 从数组中获取值
     * @return
     */
if (!function_exists('get_from_array'))
{
    function get_from_array($array, $by, $value, $this)
    {
        if (!$array) return false;
        foreach ($array as $line) {
            if ($line[$by] == $value) {
                return $line[$this];
            }
        }
        return false;
    }
}

// --------------------------------------------------------------------

/**
 * 获取此分类下所有分类以及自己
 * @todo 以后优化
 * @param 
 * @return $array
 */
if (!function_exists('getSonCategory'))
{
    function getSonCategory($array, $tid, $a = array())
    {
        $a[] = $tid;
        foreach ($array as $line) {
            if ($line['reid'] == $tid) {
                $a[] = $line['id'];
                $a = getSonCategory($array, $line['id'], $a);
            }
        }
        $b = array_unique($a);
        return $b;
    }
}

// --------------------------------------------------------------------



if (!function_exists('add_table_prefix'))
{
    /**
     * add_table_prefix()
     * 给字段加上表前缀
     * @param mixed $table
     * @param mixed $fields
     * @return
     */
    function add_table_prefix($table, $fields)
    {
        $a = explode(',', $fields);
        foreach ($a as $line) {
            $b[] = $table.'.'.trim($line);
        }
        return implode(',', $b);
    }
}
// --------------------------------------------------------------------

    /**
     * getrefer()
     * 获取上一页地址
     * @return
     */
if (!function_exists('getrefer'))
{
    function getrefer($uri = 'admin/index')
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $refer = $_SERVER['HTTP_REFERER'];
        } else {
            $refer = site_url($uri);
        }
        return $refer;
    }
}

// --------------------------------------------------------------------

/**
 * 输出属性
 * @param 
 * @return html
 */
if (!function_exists('showflag'))
{
    function showflag($type = 'checkbox', $flag = '')
    {
        $array = array('c' => '推荐[c]', 't' => '置顶[t]', 'f' => '幻灯[f]', 's' => '滚动[s]');
        $flag ? $flagArray = explode(',', $flag) : '';
        $html = '';
        if ($type == 'checkbox')
        {
            foreach ($array as $key => $value)
            {
                $html .= '&nbsp;&nbsp;&nbsp;<input type = "checkbox" name= "flag[]" value = "' .
                    $key . '" ' . ($flag && in_array($key, $flagArray) ? 'checked' : '') . ' /> ' .
                    $value;
            }
        }
        else
        {
            if ($flag)
            {
                foreach ($array as $key => $value)
                {
                    in_array($key, $flagArray) ? $html .= ' ' . $value . ' ' : $html .= '';
                }
            }
        }
        echo $html;
    }
}

// --------------------------------------------------------------------

/**
 * 输出标签
 * @param 
 * @return html
 */
if (!function_exists('showtag'))
{
    function showtag($tag, $array, $sprintf, $separator = '、')
    {
        if(!$tag) return false;
        $tag = array_filter(explode(',', $tag));
        foreach ($tag as $line) {
            $return[] = sprintf($sprintf, $array[$line]['tag'], $array[$line]['tag']);
        }
        return implode($separator, $return);
    }
}

// --------------------------------------------------------------------

if (!function_exists('sendmail'))
{
    /**
     * sendmail()
     * 发送邮件
     * @param mixed $to
     * @param mixed $subject
     * @param mixed $message
     * @return
     */
    function sendmail($to, $subject, $message)
    {
        $CI = & get_instance();
        include ('application/config/email.php');
        $CI->load->library('email', $config);
        $CI->email->from($config['smtp_user'], $config['smtp_user']);
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);        
        if ($CI->email->send()) {
            return 'success';
        }
        return $CI->email->print_debugger();
    }
}

// --------------------------------------------------------------------

if (!function_exists('getSubByKey'))
{
    /**
     * getSubByKey()
     * 通过主键获取一个数组
     * @param mixed $pArray
     * @param string $pKey
     * @param string $pCondition
     * @return
     */
    function getSubByKey($pArray, $pKey = "", $pCondition = "") {
    	$result = array();
    	if (!$pArray) {
    		return $result;
    	}
    	foreach ($pArray as $tempArray) {
    		if (is_object($tempArray)) {
    			$tempArray = (array)$tempArray;
    		}
    		if (("" != $pCondition && $tempArray[$pCondition[0]] == $pCondition[1]) || "" == $pCondition) {
    			$result[] = ("" == $pKey) ? $tempArray : isset($tempArray[$pKey]) ? $tempArray[$pKey] : "";
    		}
    	}
    	return $result;
    }
}

/* End of file common_helper.php */
/* Location: ./application/helpers/common_helper.php */
